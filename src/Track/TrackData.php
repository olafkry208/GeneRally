<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track;

use Kryus\GeneRally\Track\TrackData\AiLine;
use Kryus\GeneRally\Track\TrackData\Checkpoint;
use Kryus\GeneRally\Track\TrackData\Header;
use Kryus\GeneRally\Track\TrackData\Heightmap;
use Kryus\GeneRally\Track\TrackData\Landmap;
use Kryus\GeneRally\Track\TrackData\PitCrew;
use Kryus\GeneRally\Track\TrackData\Properties;
use Kryus\GeneRally\Track\TrackData\TrackObject;

class TrackData
{
    /** @var Header */
    private $header;

    /** @var Properties */
    private $properties;

    /** @var Landmap */
    private $landmap;

    /** @var Heightmap */
    private $heightmap;

    /** @var TrackObject[] */
    private $objects;

    /** @var PitCrew[] */
    private $pitCrews;

    /** @var Checkpoint[] */
    private $checkpoints;

    /** @var AiLine */
    private $aiLine;

    /** @var AiLine */
    private $aiLinePit;

    /**
     * @param Header $header
     * @param Properties $properties
     * @param Landmap $landmap
     * @param Heightmap $heightmap
     * @param TrackObject[] $objects
     * @param PitCrew[] $pitCrews
     * @param Checkpoint[] $checkpoints
     * @param AiLine $aiLine
     * @param AiLine $aiLinePit
     */
    public function __construct(
        Header $header,
        Properties $properties,
        Landmap $landmap,
        Heightmap $heightmap,
        array $objects,
        array $pitCrews,
        array $checkpoints,
        AiLine $aiLine,
        AiLine $aiLinePit
    ) {
        $this->header = $header;
        $this->properties = $properties;
        $this->landmap = $landmap;
        $this->heightmap = $heightmap;
        $this->objects = $objects;
        $this->pitCrews = $pitCrews;
        $this->checkpoints = $checkpoints;
        $this->aiLine = $aiLine;
        $this->aiLinePit = $aiLinePit;
    }

    /**
     * @return Header
     */
    public function getHeader(): Header
    {
        return $this->header;
    }

    /**
     * @return Properties
     */
    public function getProperties(): Properties
    {
        return $this->properties;
    }

    /**
     * @return Landmap
     */
    public function getLandmap(): Landmap
    {
        return $this->landmap;
    }

    /**
     * @return Heightmap
     */
    public function getHeightmap(): Heightmap
    {
        return $this->heightmap;
    }

    /**
     * @return TrackObject[]
     */
    public function getObjects(): array
    {
        return $this->objects;
    }

    /**
     * @return PitCrew[]
     */
    public function getPitCrews(): array
    {
        return $this->pitCrews;
    }

    /**
     * @return Checkpoint[]
     */
    public function getCheckpoints(): array
    {
        return $this->checkpoints;
    }

    /**
     * @return AiLine
     */
    public function getAiLine(): AiLine
    {
        return $this->aiLine;
    }

    /**
     * @return AiLine
     */
    public function getAiLinePit(): AiLine
    {
        return $this->aiLinePit;
    }
}