<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData\Landmap;

class Pixel
{
    public const SURFACE_TARMAC1 = 0;
    public const SURFACE_TARMAC2 = 1;
    public const SURFACE_GRASS = 2;
    public const SURFACE_BORDER = 3;
    public const SURFACE_MUD = 4;
    public const SURFACE_GRAVEL = 5;
    public const SURFACE_SAND = 6;
    public const SURFACE_SNOW = 7;
    public const SURFACE_ICE = 8;
    public const SURFACE_WHITE_LINE = 9;
    public const SURFACE_YELLOW_LINE = 10;
    public const SURFACE_RED_LINE = 11;
    public const SURFACE_OIL = 12;

    private const PIXEL_COLOR = [
        self::SURFACE_TARMAC1 => [160, 160, 160],
        self::SURFACE_TARMAC2 => [180, 180, 180],
        self::SURFACE_GRASS => [144, 220, 96],
        self::SURFACE_BORDER => [190, 200, 128],
        self::SURFACE_MUD => [150, 140, 100],
        self::SURFACE_GRAVEL => [190, 180, 160],
        self::SURFACE_SAND => [240, 220, 210],
        self::SURFACE_SNOW => [246, 251, 254],
        self::SURFACE_ICE => [220, 231, 240],
        self::SURFACE_WHITE_LINE => [255, 255, 255],
        self::SURFACE_YELLOW_LINE => [255, 255, 0],
        self::SURFACE_RED_LINE => [255, 0, 0],
        self::SURFACE_OIL => [63, 63, 63],
        13 => [0, 0, 0],
        14 => [0, 0, 0],
        15 => [0, 0, 0],
    ];

    /** @var int */
    private $surface;

    /** @var int */
    private $x;

    /** @var int */
    private $y;

    /**
     * @param int $surface
     * @throws \Exception
     */
    public function __construct(int $surface, int $x, int $y)
    {
        if ($surface < 0 || $surface > 15) {
            throw new \Exception("Invalid landmap color index “{$surface}”.");
        }

        $this->surface = $surface;
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getSurface(): int
    {
        return $this->surface;
    }

    /**
     * @return array
     */
    public function getColor(): array
    {
        return self::PIXEL_COLOR[$this->surface];
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }
}
