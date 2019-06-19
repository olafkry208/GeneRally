<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Ini;

class Misc
{
    /**
     * Setting this to 1 may result in smoother gameplay on slower computers
     * Default: 0
     *
     * @var bool
     */
    private $alternativeSpeedSetting;

    /**
     * Screenshot width and height apply to screenshots saved by pressing F11
     * Defaults: 800, 600
     *
     * @var int
     */
    private $screenshotWidth;

    /**
     * Screenshot width and height apply to screenshots saved by pressing F11
     * Defaults: 800, 600
     *
     * @var int
     */
    private $screenshotHeight;

    /**
     * Fileformat for screenshots (F11 only). Currently only BMP is supported.
     *
     * @var string
     */
    private $screenshotFormat;

    /**
     * @param bool $alternativeSpeedSetting
     * @param int $screenshotWidth
     * @param int $screenshotHeight
     * @param string $screenshotFormat
     */
    public function __construct(
        bool $alternativeSpeedSetting = false,
        int $screenshotWidth = 800,
        int $screenshotHeight = 600,
        string $screenshotFormat = 'BMP'
    ) {
        $this->alternativeSpeedSetting = $alternativeSpeedSetting;
        $this->screenshotWidth = $screenshotWidth;
        $this->screenshotHeight = $screenshotHeight;
        $this->screenshotFormat = $screenshotFormat;
    }

    /**
     * @return bool
     */
    public function isAlternativeSpeedSetting(): bool
    {
        return $this->alternativeSpeedSetting;
    }

    /**
     * @return int
     */
    public function getScreenshotWidth(): int
    {
        return $this->screenshotWidth;
    }

    /**
     * @return int
     */
    public function getScreenshotHeight(): int
    {
        return $this->screenshotHeight;
    }

    /**
     * @return string
     */
    public function getScreenshotFormat(): string
    {
        return $this->screenshotFormat;
    }
}