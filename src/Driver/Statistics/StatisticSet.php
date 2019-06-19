<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Driver\Statistics;

use Kryus\GeneRally\DataType\Dword;

class StatisticSet
{
    /** @var int */
    private $totalCount;

    /** @var int */
    private $winCount;

    /** @var int */
    private $secondPlaceCount;

    /** @var int */
    private $thirdPlaceCount;

    /** @var int */
    private $fourthPlaceCount;

    /** @var int */
    private $fifthPlaceCount;

    /** @var int */
    private $sixthPlaceCount;

    /**
     * @param Dword $totalCount
     * @param Dword $winCount
     * @param Dword $secondPlaceCount
     * @param Dword $thirdPlaceCount
     * @param Dword $fourthPlaceCount
     * @param Dword $fifthPlaceCount
     * @param Dword $sixthPlaceCount
     */
    public function __construct(
        Dword $totalCount,
        Dword $winCount,
        Dword $secondPlaceCount,
        Dword $thirdPlaceCount,
        Dword $fourthPlaceCount,
        Dword $fifthPlaceCount,
        Dword $sixthPlaceCount
    ) {
        $this->totalCount = $totalCount->toInt();
        $this->winCount = $winCount->toInt();
        $this->secondPlaceCount = $secondPlaceCount->toInt();
        $this->thirdPlaceCount = $thirdPlaceCount->toInt();
        $this->fourthPlaceCount = $fourthPlaceCount->toInt();
        $this->fifthPlaceCount = $fifthPlaceCount->toInt();
        $this->sixthPlaceCount = $sixthPlaceCount->toInt();
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * @return int
     */
    public function getWinCount(): int
    {
        return $this->winCount;
    }

    /**
     * @return int
     */
    public function getSecondPlaceCount(): int
    {
        return $this->secondPlaceCount;
    }

    /**
     * @return int
     */
    public function getThirdPlaceCount(): int
    {
        return $this->thirdPlaceCount;
    }

    /**
     * @return int
     */
    public function getFourthPlaceCount(): int
    {
        return $this->fourthPlaceCount;
    }

    /**
     * @return int
     */
    public function getFifthPlaceCount(): int
    {
        return $this->fifthPlaceCount;
    }

    /**
     * @return int
     */
    public function getSixthPlaceCount(): int
    {
        return $this->sixthPlaceCount;
    }
}