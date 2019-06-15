<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData\Properties;

use Kryus\GeneRally\DataType\SignedWord;

class ViewAngle
{
    /** @var int */
    private $value;

    public function __construct(SignedWord $value)
    {
        $this->value = $value->toInt();
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}