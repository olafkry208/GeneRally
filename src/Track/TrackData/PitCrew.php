<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData;

use Kryus\GeneRally\DataType\Word;

class PitCrew
{
    /** @var int */
    private $x;

    /** @var int */
    private $y;

    /** @var float */
    private $rotation;

    /**
     * @param Word $x
     * @param Word $y
     * @param Word $rotation
     */
    public function __construct(Word $x, Word $y, Word $rotation)
    {
        $this->x = $x->toInt();
        $this->y = $y->toInt();
        $this->rotation = $rotation->toInt();
    }
}