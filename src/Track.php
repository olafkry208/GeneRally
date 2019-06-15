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

        $propertiesSectionStart = $stream->readWord(); // 0xFFFF

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

        $propertiesSectionEnd = $stream->readWord(); // 0xFFFF

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
        $timeData = new TimeData();

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