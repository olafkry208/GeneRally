<?php
declare(strict_types=1);

namespace Kryus\GeneRally;

use Kryus\GeneRally\DataType\ByteStream;
use Kryus\GeneRally\Track\Header;
use Kryus\GeneRally\Track\TimeData;
use Kryus\GeneRally\Track\TrackData;

class Track
{
    /** @var Header */
    private $header;

    /** @var TrackData */
    private $trackData;

    /** @var TimeData */
    private $timeData;

    /**
     * @param Header $header
     * @param TrackData $trackData
     * @param TimeData $timeData
     */
    public function __construct(Header $header, TrackData $trackData, TimeData $timeData)
    {
        $this->header = $header;
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
    private static function createFromStream(ByteStream $stream): Track
    {
        //TODO - Add 1.2 support

        $header = new Header($stream->readDword());

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
        /** @var TrackData\TrackObject[] $objects */
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
        /** @var TrackData\PitCrew[] $pitCrews */
        $pitCrews = [];
        for ($i = 0; $i < $pitCrewCount; ++$i) {
            $pitCrewX = $stream->readWord();
            $pitCrewY = $stream->readWord();
            $pitCrewRotation = $stream->readWord();

            $pitCrews[] = new TrackData\PitCrew($pitCrewX, $pitCrewY, $pitCrewRotation);
        }

        $checkpointCount = $stream->readByte()->toInt();
        /** @var TrackData\Checkpoint[] $checkpoints */
        $checkpoints = [];
        for ($i = 0; $i < $checkpointCount; ++$i) {
            $checkpointX1 = $stream->readWord();
            $checkpointY1 = $stream->readWord();
            $checkpointX2 = $stream->readWord();
            $checkpointY2 = $stream->readWord();

            $checkpoints[] = new TrackData\Checkpoint($checkpointX1, $checkpointY1, $checkpointX2, $checkpointY2);
        }

        $aiLineNodeCount = $stream->readWord()->toInt();
        /** @var TrackData\AiLine\Node[] $aiLineNodes */
        $aiLineNodes = [];
        for ($i = 0; $i < $aiLineNodeCount; ++$i) {
            $aiLineNodeX = $stream->readWord();
            $alLineNodeY = $stream->readWord();

            $aiLineNodes[] = new TrackData\AiLine\Node($aiLineNodeX, $alLineNodeY);
        }
        $aiLine = new TrackData\AiLine($aiLineNodes);

        $aiLinePitNodeCount = $stream->readByte()->toInt();
        /** @var TrackData\AiLine\Node[] $aiLinePitNodes */
        $aiLinePitNodes = [];
        for ($i = 0; $i < $aiLinePitNodeCount; ++$i) {
            $aiLinePitNodeX = $stream->readWord();
            $alLinePitNodeY = $stream->readWord();

            $aiLinePitNodes[] = new TrackData\AiLine\Node($aiLinePitNodeX, $alLinePitNodeY);
        }
        $aiLinePit = new TrackData\AiLine($aiLinePitNodes);

        $authorSectionStart = $stream->readWord(); // 0xFFFF

        $author = $stream->readString(30, 'ASCII');
        $authorsComments = $stream->readString(500, 'ASCII');

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
            $properties,
            $landmap,
            $heightmap,
            $objects,
            $pitCrews,
            $checkpoints,
            $aiLine,
            $aiLinePit
        );

        /** @var TimeData\LapTime[] $lapTimes */
        $lapTimes = [];
        for ($i = 0; $i < 7; $i++) {
            $lapTimes[$i] = new TimeData\LapTime($stream->readWord());
        }

        /** @var string[] $lapTimes */
        $driverNames = [];
        for ($i = 0; $i < 7; $i++) {
            $driverNames[$i] = $stream->readString(13, 'ASCII');
        }

        /** @var Car[] $cars */
        $cars = [];
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 1344; $j++) {
                $stream->readByte(); //TODO - Car processing
            }

            $cars[$i] = new Car();
        }

        /** @var \DateTimeImmutable[] $cars */
        $dateTimes = [];
        for ($i = 0; $i < 7; $i++) {
            $year = str_pad((string)$stream->readWord()->toInt(), 4, '0', STR_PAD_LEFT);
            $month = str_pad((string)$stream->readWord()->toInt(), 2, '0', STR_PAD_LEFT);
            $weekday = $stream->readWord()->toInt();
            $day = str_pad((string)$stream->readWord()->toInt(), 2, '0', STR_PAD_LEFT);
            $hour = str_pad((string)$stream->readWord()->toInt(), 2, '0', STR_PAD_LEFT);
            $minute = str_pad((string)$stream->readWord()->toInt(), 2, '0', STR_PAD_LEFT);
            $second = str_pad((string)$stream->readWord()->toInt(), 2, '0', STR_PAD_LEFT);
            $millisecond = str_pad((string)$stream->readWord()->toInt(), 3, '0', STR_PAD_LEFT);

            $dateTimes[$i] = new \DateTimeImmutable("{$year}-{$month}-{$day} {$hour}:{$minute}:{$second}.{$millisecond} UTC");
        }

        /** @var TimeData\BestTime|null $trackRecord */
        $trackRecord = null;
        /** @var TimeData\BestTime[] $bestTimes */
        $bestTimes = [];
        for ($i = 0; $i < 7; $i++) {
            if ($lapTimes[$i]->toCentiseconds() < 6000) {
                $bestTime = new TimeData\BestTime($lapTimes[$i], $driverNames[$i], $cars[$i], $dateTimes[$i]);

                if ($i === 0) {
                    $trackRecord = $bestTime;
                } else {
                    $bestTimes[$i] = $bestTime;
                }
            } elseif ($i > 0) {
                break;
            }
        }

        $ghost = null;
        if (!$stream->isEof()) {
            $ghostLapTime = new TimeData\LapTime($stream->readWord());

            $ghostFrameCount = 1 + (int)floor($ghostLapTime->toCentiseconds() / 2);
            /** @var TimeData\Ghost\Node[] $ghostFrames */
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

        $timeData = new TimeData($trackRecord, $bestTimes, $ghost);

        return new self($header, $trackData, $timeData);
    }

    /**
     * @return Header
     */
    public function getHeader(): Header
    {
        return $this->header;
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