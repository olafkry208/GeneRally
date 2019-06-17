<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TimeData;

use Kryus\GeneRally\Car;

class BestTime
{
    /** @var LapTime */
    private $lapTime;

    /** @var string */
    private $driverName;

    /** @var Car */
    private $car;

    /** @var \DateTimeImmutable */
    private $dateTime;

    /**
     * @param LapTime $lapTime
     * @param string $driverName
     * @param Car $car
     * @param \DateTimeImmutable $dateTime
     */
    public function __construct(LapTime $lapTime, string $driverName, Car $car, \DateTimeImmutable $dateTime)
    {
        $this->lapTime = $lapTime;
        $this->driverName = $driverName;
        $this->car = $car;
        $this->dateTime = $dateTime;
    }

    /**
     * @return LapTime
     */
    public function getLapTime(): LapTime
    {
        return $this->lapTime;
    }

    /**
     * @return string
     */
    public function getDriverName(): string
    {
        return $this->driverName;
    }

    /**
     * @return Car
     */
    public function getCar(): Car
    {
        return $this->car;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateTime(): \DateTimeImmutable
    {
        return $this->dateTime;
    }
}