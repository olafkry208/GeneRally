<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\Header;

use Kryus\GeneRally\DataType\Word;

class Version
{
    /** @var int */
    private $major;

    /** @var int */
    private $minor;

    public function __construct(Word $value)
    {
        $this->major = (int)$value->getHighByte()->toHex(); //TODO - proper BCD conversion
        $this->minor = (int)$value->getLowByte()->toHex(); //TODO - proper BCD conversion
    }

    public function __toString()
    {
        return $this->major . '.' . ($this->minor < 10 ? ('0' . $this->minor) : $this->minor);
    }
}