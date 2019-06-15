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

        $trackLength = 999; //TODO
        $author = 'Tester'; //TODO
        $authorsComments = 'Test.'; //TODO

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

        $pitCrews = []; //TODO
        $checkpoints = []; //TODO
        $aiLine = new TrackData\AiLine(); //TODO
        $aiLinePit = new TrackData\AiLine(); //TODO

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