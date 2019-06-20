<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TimeData;

use Kryus\Binary\DataType\Byte;
use Kryus\Binary\DataType\Word;

class LapTime
{
    /** @var int */
    private $seconds;

    /** @var int */
    private $centiseconds;

    /**
     * @param Word $time
     */
    public function __construct(Word $time)
    {
        $value = $time->toInt();

        $this->centiseconds = $value % 100;
        $this->seconds = (int)($value / 100);
    }

    public function __toString()
    {
        return $this->seconds . '.' . ($this->centiseconds < 10 ? ('0' . $this->centiseconds) : $this->centiseconds);
    }

    public function toFloat(): float
    {
        return $this->seconds + $this->centiseconds * 0.01;
    }

    public function toCentiseconds(): int
    {
        return $this->seconds * 100 + $this->centiseconds;
    }
}