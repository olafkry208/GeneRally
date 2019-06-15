<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData\Properties;

use Kryus\GeneRally\DataType\Byte;

class SfLine
{
    /** @var bool */
    private $value;

    /**.
     * @param Byte $value
     * @throws \Exception
     */
    public function __construct(Byte $value)
    {
        $intValue = $value->toInt();

        if (!in_array($intValue, [0, 1], true)) {
            throw new \Exception("Invalid value of {$intValue} for S/F Line.");
        }

        $this->value = $value->toInt() !== 0;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}