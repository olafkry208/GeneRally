<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Driver;

use Kryus\Binary\DataType\SignedDword;

class Controls
{
    // TODO - create a keyboard key class to support control keys, arrows etc.

    /** @var string */
    private $accelerate;

    /** @var string */
    private $brake;

    /** @var string */
    private $steerLeft;

    /** @var string */
    private $steerRight;

    /**
     * Controls constructor.
     * @param SignedDword $accelerate
     * @param SignedDword $brake
     * @param SignedDword $steerLeft
     * @param SignedDword $steerRight
     */
    public function __construct(SignedDword $accelerate, SignedDword $brake, SignedDword $steerLeft, SignedDword $steerRight)
    {
        $this->accelerate = $accelerate->__toString();
        $this->brake = $brake->__toString();
        $this->steerLeft = $steerLeft->__toString();
        $this->steerRight = $steerRight->__toString();
    }

    /**
     * @return string
     */
    public function getAccelerate(): string
    {
        return $this->accelerate;
    }

    /**
     * @return string
     */
    public function getBrake(): string
    {
        return $this->brake;
    }

    /**
     * @return string
     */
    public function getSteerLeft(): string
    {
        return $this->steerLeft;
    }

    /**
     * @return string
     */
    public function getSteerRight(): string
    {
        return $this->steerRight;
    }
}