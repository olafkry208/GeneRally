<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Palette;

use Kryus\Binary\DataType\Dword;

class Color
{
    /** @var int */
    private $red;

    /** @var int */
    private $green;

    /** @var int */
    private $blue;

    public function __construct(Dword $value)
    {
        $intValue = $value->toInt();

        $this->red = ($intValue >> 16) % 256;
        $this->green = ($intValue >> 8) % 256;
        $this->blue = $intValue % 256;
    }

    public function __toString()
    {
        return sprintf('#%02x%02x%02x', $this->red, $this->green, $this->blue);
    }
}