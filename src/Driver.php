<?php
declare(strict_types=1);

namespace Kryus\GeneRally;

use Kryus\Binary\ByteStream;
use Kryus\GeneRally\Driver\AiLevel;
use Kryus\GeneRally\Driver\Colors;
use Kryus\GeneRally\Driver\ComputerDriver;
use Kryus\GeneRally\Driver\Controls;
use Kryus\GeneRally\Driver\HumanDriver;
use Kryus\GeneRally\Driver\Statistics;
use Kryus\GeneRally\Palette\Color;

abstract class Driver
{
    const TYPE_HUMAN = 0;
    const TYPE_COMPUTER = 1;

    /** @var Colors */
    private $colors;

    /** @var Statistics */
    private $statistics;

    /**
     * @param Colors $colors
     * @param Statistics $statistics
     */
    public function __construct(Colors $colors, Statistics $statistics)
    {
        $this->colors = $colors;
        $this->statistics = $statistics;
    }

    /**
     * @param string $filename
     * @return Driver
     * @throws \Exception
     */
    public static function createFromFilename(string $filename): Driver
    {
        $stream = ByteStream::createFromFilename($filename, 'rb');

        return self::createFromStream($stream);
    }

    /**
     * @param ByteStream $stream
     * @return Driver
     * @throws \Exception
     */
    private static function createFromStream(ByteStream $stream): Driver
    {
        $header = $stream->readDword(); // 0x5C 0x00 0x00 0x00 ???

        /** @var int[] $seasonValues */
        $seasonValues = [];
        for ($i = 0; $i < 7; $i++) {
            $seasonValues[] = $stream->readDword();
        }
        $seasonStatistics = new Statistics\StatisticSet(...$seasonValues);

        $totalPoints = $stream->readDword();

        /** @var int[] $raceValues */
        $raceValues = [];
        for ($i = 0; $i < 7; $i++) {
            $raceValues[] = $stream->readDword();
        }
        $raceStatistics = new Statistics\StatisticSet(...$raceValues);

        $fastestLaps = $stream->readDword();

        $statistics = new Statistics($raceStatistics, $seasonStatistics, $totalPoints, $fastestLaps);

        $a = $stream->readDword(); // ???

        $primaryColor = new Color($stream->readDword());
        $secondaryColor = new Color($stream->readDword());

        $colors = new Colors($primaryColor, $secondaryColor);

        $accelerate = $stream->readSignedDword();
        $brake = $stream->readSignedDword();
        $steerLeft = $stream->readSignedDword();
        $steerRight = $stream->readSignedDword();

        $isComputerDriver = $accelerate->toInt() === 0;

        if ($isComputerDriver) {
            $aiLevel = new AiLevel($brake);

            for ($i = 0; $i < 12; $i++) {
                $stream->readDword();
            }

            return new ComputerDriver($colors, $statistics, $aiLevel);
        }

        $controls = new Controls($accelerate, $brake, $steerLeft, $steerRight);

        for ($i = 0; $i < 12; $i++) {
            $stream->readDword();
        }

        return new HumanDriver($colors, $statistics, $controls);
    }

    /**
     * @return Colors
     */
    public function getColors(): Colors
    {
        return $this->colors;
    }

    /**
     * @return Statistics
     */
    public function getStatistics(): Statistics
    {
        return $this->statistics;
    }

    /**
     * @return int
     */
    abstract public function getType(): int;
}