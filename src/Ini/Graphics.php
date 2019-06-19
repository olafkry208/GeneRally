<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Ini;

class Graphics
{
    /**
     * Amount of video memory (kilobytes) The game uses either this value or
     * automatically detected value, whichever is greater. Default: autodetect
     *
     * @var int|null
     */
    private $videoMemory;

    /**
     * 0 (default): Off, 1: Don't draw objects in track info dialog.
     *
     * @var bool
     */
    private $fasterTrackPreview;

    /**
     * 0: Off, 1 (default): Better visual quality of vehicles.
     *
     * @var bool
     */
    private $tyreAutoSort;

    /**
     * @param int|null $videoMemory
     * @param bool $fasterTrackPreview
     * @param bool $tyreAutoSort
     */
    public function __construct(?int $videoMemory = null, bool $fasterTrackPreview = false, bool $tyreAutoSort = true)
    {
        $this->videoMemory = $videoMemory;
        $this->fasterTrackPreview = $fasterTrackPreview;
        $this->tyreAutoSort = $tyreAutoSort;
    }

    /**
     * @return int|null
     */
    public function getVideoMemory(): ?int
    {
        return $this->videoMemory;
    }

    /**
     * @return bool
     */
    public function isFasterTrackPreview(): bool
    {
        return $this->fasterTrackPreview;
    }

    /**
     * @return bool
     */
    public function isTyreAutoSort(): bool
    {
        return $this->tyreAutoSort;
    }
}