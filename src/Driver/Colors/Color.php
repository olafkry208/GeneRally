<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Driver\Colors;

use Kryus\GeneRally\DataType\Byte;

class Color
{
    /** @var int */
    private $red;

    /** @var int */
    private $green;

    /** @var int */
    private $blue;

    public function __construct(Byte $red, Byte $green, Byte $blue)
    {
        $this->red = $red->toInt();
        $this->green = $green->toInt();
        $this->blue = $blue->toInt();
    }

    public function __toString()
    {
        return sprintf('#%02x%02x%02x', $this->red, $this->green, $this->blue);
    }
}