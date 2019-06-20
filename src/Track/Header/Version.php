<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\Header;

use Kryus\Binary\DataType\Word;

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
        return $this->major . '.' . str_pad((string)$this->minor, 2, '0', STR_PAD_LEFT);
    }
}