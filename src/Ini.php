<?php
declare(strict_types=1);

namespace Kryus\GeneRally;

use Kryus\GeneRally\Ini\Graphics;
use Kryus\GeneRally\Ini\Misc;
use Kryus\GeneRally\Ini\Replay;
use Kryus\GeneRally\Ini\Viewport;

class Ini
{
    /** @var Replay */
    private $replay;

    /** @var Graphics */
    private $graphics;

    /** @var Viewport */
    private $viewport;

    /** @var Misc */
    private $misc;

    /**
     * @param Replay $replay
     * @param Graphics $graphics
     * @param Viewport $viewport
     * @param Misc $misc
     */
    public function __construct(Replay $replay, Graphics $graphics, Viewport $viewport, Misc $misc)
    {
        $this->replay = $replay;
        $this->graphics = $graphics;
        $this->viewport = $viewport;
        $this->misc = $misc;
    }

    /**
     * @param string $filename
     * @return Ini
     */
    public static function createFromFilename(string $filename): Ini
    {
        $array = parse_ini_file($filename, true);

        return self::createFromArray($array);
    }

    /**
     * @param array $array
     * @return Ini
     */
    private static function createFromArray(array $array): Ini
    {
        $replay = new Replay(
            is_numeric($array['Replay']['Length'] ?? 600) ? (int)$array['Replay']['Length'] : 600,
            is_numeric($array['Replay']['FrameStep'] ?? 5) ? (int)$array['Replay']['FrameStep'] : 5
        );

        $graphics = new Graphics(
            is_numeric($array['Graphics']['VideoMemory'] ?? null) ? (int)$array['Graphics']['VideoMemory'] : null,
            ($array['Graphics']['FasterTrackPreview'] ?? '0') === '1',
            ($array['Graphics']['TyreAutoSort'] ?? '1') !== '0'
        );

        $viewport = new Viewport(
            is_numeric($array['Viewport']['ViewAngle'] ?? null) ? (int)$array['Viewport']['ViewAngle'] : null,
            is_numeric($array['Viewport']['Rotation'] ?? null) ? (int)$array['Viewport']['Rotation'] : null,
            is_numeric($array['Viewport']['Zoom'] ?? null) ? (int)$array['Viewport']['Zoom'] : null
        );

        $misc = new Misc(
            ($array['Misc']['AlternativeSpeedSetting'] ?? '0') === '1',
            is_numeric($array['Misc']['ScreenshotWidth'] ?? 800) ? (int)$array['Misc']['ScreenshotWidth'] : 800,
            is_numeric($array['Misc']['ScreenshotHeight'] ?? 800) ? (int)$array['Misc']['ScreenshotHeight'] : 800,
            (string)($array['Misc']['ScreenshotFormat'] ?? 'BMP')
        );

        return new self($replay, $graphics, $viewport, $misc);
    }

    /**
     * @return Replay
     */
    public function getReplay(): Replay
    {
        return $this->replay;
    }

    /**
     * @return Graphics
     */
    public function getGraphics(): Graphics
    {
        return $this->graphics;
    }

    /**
     * @return Viewport
     */
    public function getViewport(): Viewport
    {
        return $this->viewport;
    }

    /**
     * @return Misc
     */
    public function getMisc(): Misc
    {
        return $this->misc;
    }
}