<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TimeData\Ghost;

use Kryus\GeneRally\DataType\Word;

class Node
{
    /** @var int */
    private $x;

    /** @var int */
    private $y;

    /** @var int */
    private $z;

    /** @var int */
    private $rotationX;

    /** @var int */
    private $rotationY;

    /** @var int */
    private $rotationZ;

    /**
     * @param Word $x
     * @param Word $y
     */
    public function __construct(Word $x, Word $y, Word $z, Word $rotationX, Word $rotationY, Word $rotationZ)
    {
        $this->x = $x->toInt();
        $this->y = $y->toInt();
        $this->z = $z->toInt();
        $this->rotationX = $x->toInt();
        $this->rotationY = $y->toInt();
        $this->rotationZ = $z->toInt();
    }
}