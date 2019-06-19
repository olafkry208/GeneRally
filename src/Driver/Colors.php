<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Driver;

use Kryus\GeneRally\Palette\Color;

class Colors
{
    /** @var Color */
    private $primaryColor;

    /** @var Color */
    private $secondaryColor;

    public function __construct(Color $primaryColor, Color $secondaryColor)
    {
        $this->primaryColor = $primaryColor;
        $this->secondaryColor = $secondaryColor;
    }
}