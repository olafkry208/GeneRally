<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData;

use Kryus\GeneRally\Track\TrackData\Properties\Rotation;
use Kryus\GeneRally\Track\TrackData\Properties\SfLine;
use Kryus\GeneRally\Track\TrackData\Properties\ViewAngle;
use Kryus\GeneRally\Track\TrackData\Properties\WaterLevel;
use Kryus\GeneRally\Track\TrackData\Properties\WorldSize;
use Kryus\GeneRally\Track\TrackData\Properties\Zoom;

class Properties
{
    /** @var WaterLevel */
    private $waterLevel;

    /** @var ViewAngle */
    private $viewAngle;

    /** @var Rotation */
    private $rotation;

    /** @var Zoom */
    private $zoom;

    /** @var WorldSize */
    private $worldSize;

    /** @var SfLine */
    private $sfLine;

    /** @var int */
    private $trackLength;

    /** @var string */
    private $author;

    /** @var string */
    private $authorsComments;

    /**
     * @param WaterLevel $waterLevel
     * @param ViewAngle $viewAngle
     * @param Rotation $rotation
     * @param Zoom $zoom
     * @param WorldSize $worldSize
     * @param SfLine $sfLine
     * @param int $trackLength
     * @param string $author
     * @param string $authorsComments
     */
    public function __construct(
        WaterLevel $waterLevel,
        ViewAngle $viewAngle,
        Rotation $rotation,
        Zoom $zoom,
        WorldSize $worldSize,
        SfLine $sfLine,
        int $trackLength,
        string $author,
        string $authorsComments
    ) {
        $this->waterLevel = $waterLevel;
        $this->viewAngle = $viewAngle;
        $this->rotation = $rotation;
        $this->zoom = $zoom;
        $this->worldSize = $worldSize;
        $this->sfLine = $sfLine;
        $this->trackLength = $trackLength;
        $this->author = $author;
        $this->authorsComments = $authorsComments;
    }

    /**
     * @return WaterLevel
     */
    public function getWaterLevel(): WaterLevel
    {
        return $this->waterLevel;
    }

    /**
     * @return ViewAngle
     */
    public function getViewAngle(): ViewAngle
    {
        return $this->viewAngle;
    }

    /**
     * @return Rotation
     */
    public function getRotation(): Rotation
    {
        return $this->rotation;
    }

    /**
     * @return Zoom
     */
    public function getZoom(): Zoom
    {
        return $this->zoom;
    }

    /**
     * @return WorldSize
     */
    public function getWorldSize(): WorldSize
    {
        return $this->worldSize;
    }

    /**
     * @return SfLine
     */
    public function getSfLine(): SfLine
    {
        return $this->sfLine;
    }

    /**
     * @return int
     */
    public function getTrackLength(): int
    {
        return $this->trackLength;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getAuthorsComments(): string
    {
        return $this->authorsComments;
    }
}