<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Driver;

use Kryus\GeneRally\DataType\Dword;
use Kryus\GeneRally\Driver\Statistics\StatisticSet;

class Statistics
{
    /** @var StatisticSet */
    private $raceStatistics;

    /** @var StatisticSet */
    private $seasonStatistics;

    /** @var int */
    private $totalPoints;

    /** @var int */
    private $fastestLaps;

    public function __construct(StatisticSet $raceStatistics, StatisticSet $seasonStatistics, Dword $totalPoints, Dword $fastestLaps)
    {
        $this->raceStatistics = $raceStatistics;
        $this->seasonStatistics = $seasonStatistics;
        $this->totalPoints = $totalPoints->toInt();
        $this->fastestLaps = $fastestLaps->toInt();
    }

    /**
     * @return StatisticSet
     */
    public function getRaceStatistics(): StatisticSet
    {
        return $this->raceStatistics;
    }

    /**
     * @return StatisticSet
     */
    public function getSeasonStatistics(): StatisticSet
    {
        return $this->seasonStatistics;
    }

    /**
     * @return int
     */
    public function getTotalPoints(): int
    {
        return $this->totalPoints;
    }

    /**
     * @return int
     */
    public function getFastestLaps(): int
    {
        return $this->fastestLaps;
    }
}