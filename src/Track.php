<?php
declare(strict_types=1);

namespace Kryus\GeneRally;

use Kryus\GeneRally\DataType\ByteStream;
use Kryus\GeneRally\Track\TimeData;
use Kryus\GeneRally\Track\TrackData;

class Track
{
    /** @var TrackData */
    private $trackData;

    /** @var TimeData */
    private $timeData;

    /**
     * @param TrackData $trackData
     * @param TimeData $timeData
     */
    public function __construct(TrackData $trackData, TimeData $timeData)
    {
        $this->trackData = $trackData;
        $this->timeData = $timeData;
    }

    /**
     * @param string $filename
     * @return Track
     * @throws \Exception
     */
    public static function createFromFile(string $filename): Track
    {
        $stream = ByteStream::createFromFile($filename);

        return self::createFromStream($stream);
    }

    /**
     * @param ByteStream $stream
     * @return Track
     * @throws \Exception
     */
    public static function createFromStream(ByteStream $stream): Track
    {
        //TODO - Add 1.2 support

        $header = new TrackData\Header($stream->readDword());

        $timeDataAddress = $stream->readDword()->toInt();

        $worldSize = new TrackData\Properties\WorldSize($stream->readByte());
        $waterLevel = new TrackData\Properties\WaterLevel($stream->readByte());
        $viewAngle = new TrackData\Properties\ViewAngle($stream->readSignedWord());
        $rotation = new TrackData\Properties\Rotation($stream->readSignedWord());
        $zoom = new TrackData\Properties\Zoom($stream->readByte());
        $sfLine = new TrackData\Properties\SfLine($stream->readByte());

        $landmapLength = $stream->readDword()->toInt();
        $landmapValues = [];
        for ($i = 0; $i < $landmapLength; ++$i) {
            $landmapValues[] = $stream->readWord();
        }
        $landmap = new TrackData\Landmap($landmapValues);

        $heightmapLength = $stream->readWord()->toInt();
        $heightmapValues = [];
        for ($i = 0; $i < $heightmapLength; ++$i) {
            $heightmapValues[] = $stream->readByte();
        }
        $heightmap = new TrackData\Heightmap($heightmapValues);

        $objectCount = $stream->readWord()->toInt();
        $objects = [];
        for ($i = 0; $i < $objectCount; ++$i) {
            $objectType = $stream->readByte();
            $objectSeed = $stream->readByte();
            $objectX = $stream->readWord();
            $objectY = $stream->readWord();
            $objectRotation = $stream->readWord();

            $objects[] = new TrackData\TrackObject($objectType, $objectSeed, $objectX, $objectY, $objectRotation);
        }

        $pitCrewCount = $stream->readByte()->toInt();
        $pitCrews = [];
        for ($i = 0; $i < $pitCrewCount; ++$i) {
            $pitCrewX = $stream->readWord();
            $pitCrewY = $stream->readWord();
            $pitCrewRotation = $stream->readWord();

            $pitCrews[] = new TrackData\PitCrew($pitCrewX, $pitCrewY, $pitCrewRotation);
        }

        $checkpointCount = $stream->readByte()->toInt();
        $checkpoints = [];
        for ($i = 0; $i < $checkpointCount; ++$i) {
            $checkpointX1 = $stream->readWord();
            $checkpointY1 = $stream->readWord();
            $checkpointX2 = $stream->readWord();
            $checkpointY2 = $stream->readWord();

            $checkpoints[] = new TrackData\Checkpoint($checkpointX1, $checkpointY1, $checkpointX2, $checkpointY2);
        }

        $aiLineNodeCount = $stream->readWord()->toInt();
        $aiLineNodes = [];
        for ($i = 0; $i < $aiLineNodeCount; ++$i) {
            $aiLineNodeX = $stream->readWord();
            $alLineNodeY = $stream->readWord();

            $aiLineNodes[] = new TrackData\AiLine\Node($aiLineNodeX, $alLineNodeY);
        }
        $aiLine = new TrackData\AiLine($aiLineNodes);

        $aiLinePitNodeCount = $stream->readByte()->toInt();
        $aiLinePitNodes = [];
        for ($i = 0; $i < $aiLinePitNodeCount; ++$i) {
            $aiLinePitNodeX = $stream->readWord();
            $alLinePitNodeY = $stream->readWord();

            $aiLinePitNodes[] = new TrackData\AiLine\Node($aiLinePitNodeX, $alLinePitNodeY);
        }
        $aiLinePit = new TrackData\AiLine($aiLinePitNodes);

        $authorSectionStart = $stream->readWord(); // 0xFFFF

        $author = '';
        for ($i = 0; $i < 30; $i++) {
            $authorChar = $stream->readByte();
            if ($authorChar->toInt() !== 0) {
                $author .= $authorChar->__toString();
            }
        }

        $authorsComments = '';
        for ($i = 0; $i < 500; $i++) {
            $authorsCommentsChar = $stream->readByte();
            if ($authorsCommentsChar->toInt() !== 0) {
                $authorsComments .= $authorsCommentsChar->__toString();
            }
        }

        $authorSectionEnd = $stream->readWord(); // 0xFFFF

        $trackLength = $stream->readDword()->toInt();

        $properties = new TrackData\Properties(
            $waterLevel,
            $viewAngle,
            $rotation,
            $zoom,
            $worldSize,
            $sfLine,
            $trackLength,
            $author,
            $authorsComments
        );

        $trackData = new TrackData(
            $header,
            $properties,
            $landmap,
            $heightmap,
            $objects,
            $pitCrews,
            $checkpoints,
            $aiLine,
            $aiLinePit
        );

        $lapTimes = [];
        for ($i = 0; $i < 7; $i++) {
            $lapTimes[] = new TimeData\LapTime($stream->readWord());
        }

        $driverNames = [];
        for ($i = 0; $i < 7; $i++) {
            $driverName = '';
            for ($j = 0; $j < 13; $j++) {
                $driverNameChar = $stream->readByte();
                if ($driverNameChar->toInt() !== 0) {
                    $driverName .= $driverNameChar->__toString();
                }
            }

            $driverNames[] = $driverName;
        }

        $cars = [];
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 1344; $j++) {
                $stream->readByte(); //TODO - Car processing
            }

            $cars[] = new Car();
        }

        $dateTimes = [];
        for ($i = 0; $i < 7; $i++) {
            $year = $stream->readWord()->toInt();
            $month = $stream->readWord()->toInt();
            $weekday = $stream->readWord()->toInt(); //TODO - verify if this really weekday
            $day = $stream->readWord()->toInt();
            $hour = $stream->readWord()->toInt();
            $minute = $stream->readWord()->toInt();
            $second = $stream->readWord()->toInt();
            $millisecond = $stream->readWord()->toInt();

            $dateTimes[] = new \DateTimeImmutable("{$year}-{$month}-{$day} {$hour}:{$minute}:{$second}.{$millisecond} UTC");
        }

        $bestTimes = [];
        for ($i = 0; $i < 7; $i++) {
            //TODO - detect when best time is empty
            $bestTimes[] = new TimeData\BestTime($lapTimes[$i], $driverNames[$i], $cars[$i], $dateTimes[$i]);
        }

        $ghost = null;
        if (!$stream->isEof()) {
            $ghostLapTime = new TimeData\LapTime($stream->readWord());

            $ghostFrameCount = 1 + (int)floor($ghostLapTime->toCentiseconds() / 2);
            $ghostFrames = [];
            for ($i = 0; $i < $ghostFrameCount; $i++) {
                $ghostFrameX = $stream->readWord();
                $ghostFrameY = $stream->readWord();
                $ghostFrameZ = $stream->readWord();
                $ghostFrameRotationX = $stream->readWord();
                $ghostFrameRotationY = $stream->readWord();
                $ghostFrameRotationZ = $stream->readWord();

                $ghostFrames[] = new TimeData\Ghost\Node(
                    $ghostFrameX,
                    $ghostFrameY,
                    $ghostFrameZ,
                    $ghostFrameRotationX,
                    $ghostFrameRotationY,
                    $ghostFrameRotationZ
                );
            }

            $checksum = '';
            for ($i = 0; $i < 16; $i++) {
                $checksum .= $stream->readByte()->__toString();
            }

            $ghost = new TimeData\Ghost($ghostLapTime, $ghostFrames, $checksum);
        }

        $timeData = new TimeData($bestTimes, $ghost);

        return new self($trackData, $timeData);
    }

    /**
     * @return TrackData
     */
    public function getTrackData(): TrackData
    {
        return $this->trackData;
    }

    /**
     * @return TimeData
     */
    public function getTimeData(): TimeData
    {
        return $this->timeData;
    }
}