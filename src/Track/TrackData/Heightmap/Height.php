<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData\Heightmap;

use Kryus\GeneRally\DataType\Byte;

class Height
{
    /** @var int */
    private $value;

    /** @var int */
    private $x;

    /** @var int */
    private $y;

    public function __construct(Byte $value, int $x, int $y)
    {
        $this->value = $value->toInt();
        $this->x = $x;
        $this->y = $y;
    }

    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * @return array
     */
    public function getColor(): array
    {
        return [$this->value, $this->value, $this->value];
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