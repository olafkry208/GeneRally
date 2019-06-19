<?php
declare(strict_types=1);

namespace Kryus\GeneRally;

use Kryus\GeneRally\DataType\ByteStream;
use Kryus\GeneRally\Driver\AiLevel;
use Kryus\GeneRally\Driver\Colors;
use Kryus\GeneRally\Driver\ComputerDriver;
use Kryus\GeneRally\Driver\Controls;
use Kryus\GeneRally\Driver\HumanDriver;
use Kryus\GeneRally\Driver\Statistics;

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
    public static function createFromFile(string $filename): Driver
    {
        $stream = ByteStream::createFromFile($filename);

        return self::createFromStream($stream);
    }

    /**
     * @param ByteStream $stream
     * @return Driver
     * @throws \Exception
     */
    public static function createFromStream(ByteStream $stream): Driver
    {
        $header = $stream->readDword(); // 0x5C 0x00 0x00 0x00 ???

        $seasonValues = [];
        for ($i = 0; $i < 7; $i++) {
            $seasonValues[] = $stream->readDword();
        }
        $seasonStatistics = new Statistics\StatisticSet(...$seasonValues);

        $totalPoints = $stream->readDword();

        $raceValues = [];
        for ($i = 0; $i < 7; $i++) {
            $raceValues[] = $stream->readDword();
        }
        $raceStatistics = new Statistics\StatisticSet(...$raceValues);

        $fastestLaps = $stream->readDword();

        $statistics = new Statistics($raceStatistics, $seasonStatistics, $totalPoints, $fastestLaps);

        $a = $stream->readDword(); // ???

        $primaryB = $stream->readByte();
        $primaryG = $stream->readByte();
        $primaryR = $stream->readByte();
        $primaryPadding = $stream->readByte();

        $primaryColor = new Colors\Color($primaryR, $primaryG, $primaryB);

        $secondaryB = $stream->readByte();
        $secondaryG = $stream->readByte();
        $secondaryR = $stream->readByte();
        $secondaryPadding = $stream->readByte();

        $secondaryColor = new Colors\Color($secondaryR, $secondaryG, $secondaryB);

        $colors = new Colors($primaryColor, $secondaryColor);

        $accelerate = $stream->readDword();
        $brake = $stream->readDword();
        $steerLeft = $stream->readDword();
        $steerRight = $stream->readDword();

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