<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData\AiLine;

use Kryus\GeneRally\DataType\Word;

class Node
{
    /** @var int */
    private $x;

    /** @var int */
    private $y;

    /**
     * @param Word $x
     * @param Word $y
     */
    public function __construct(Word $x, Word $y)
    {
        $this->x = $x->toInt();
        $this->y = $y->toInt();
    }
}