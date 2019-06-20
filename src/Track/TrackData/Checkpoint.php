<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData;

use Kryus\Binary\DataType\Word;

class Checkpoint
{
    /** @var int */
    private $x1;

    /** @var int */
    private $y1;

    /** @var int */
    private $x2;

    /** @var int */
    private $y2;

    /**
     * @param Word $x1
     * @param Word $y1
     * @param Word $x2
     * @param Word $y2
     */
    public function __construct(Word $x1, Word $y1, Word $x2, Word $y2)
    {
        $this->x1 = $x1->toInt();
        $this->y1 = $y1->toInt();
        $this->x2 = $x2->toInt();
        $this->y2 = $y2->toInt();
    }
}