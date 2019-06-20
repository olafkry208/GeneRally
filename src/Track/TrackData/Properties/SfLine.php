<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData\Properties;

use Kryus\Binary\DataType\Byte;

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

        $this->value = $intValue !== 0;
    }

    public function __toString()
    {
        return $this->value ? '1' : '0';
    }

    /**
     * @return bool
     */
    public function toBool(): bool
    {
        return $this->value;
    }
}