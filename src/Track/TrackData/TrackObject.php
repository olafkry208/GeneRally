<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData;

use Kryus\GeneRally\DataType\Byte;
use Kryus\GeneRally\DataType\Word;

class TrackObject
{
    public const OBJECT_START = 0;
    public const OBJECT_CONCRETE_WALL = 1;
    public const OBJECT_SOFT_WALL = 2;
    public const OBJECT_HAY_BALE = 3;
    public const OBJECT_PALM_TREE = 4;
    public const OBJECT_LEAF_TREE = 5;
    public const OBJECT_BUSH = 6;
    public const OBJECT_TRAFFIC_SIGN = 7;
    public const OBJECT_LIGHT = 8;
    public const OBJECT_STONE = 9;
    public const OBJECT_SUNK_TYRE = 10;
    public const OBJECT_BOOTH = 11;
    public const OBJECT_HOUSE = 12;
    public const OBJECT_OFFICE_BLOCK = 13;
    public const OBJECT_STAND = 14;
    public const OBJECT_BOAT = 15;
    public const OBJECT_PIER = 16;
    public const OBJECT_BRIDGE = 17;
    public const OBJECT_FLAT_BRIDGE = 18;
    public const OBJECT_FIR_TREE = 19;
    public const OBJECT_PINE_TREE = 20;
    public const OBJECT_CACTUS = 21;
    public const OBJECT_GATE = 22;
    public const OBJECT_FENCE = 23;
    public const OBJECT_CONCRETE_POST = 24;

    /** @var int */
    private $type;

    /** @var int */
    private $seed;

    /** @var int */
    private $x;

    /** @var int */
    private $y;

    /** @var float */
    private $rotation;

    public function __construct(Byte $type, Byte $seed, Word $x, Word $y, Word $rotation)
    {
    }
}