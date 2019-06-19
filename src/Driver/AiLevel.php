<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Driver;

use Kryus\GeneRally\DataType\SignedDword;

class AiLevel
{
    /** @var int */
    private $value;

    /**.
     * @param SignedDword $value
     * @throws \Exception
     */
    public function __construct(SignedDword $value)
    {
        $intValue = $value->toInt();

        if ($intValue < 0 || $intValue > 200) {
            throw new \Exception("Invalid value of {$intValue} for AI Level.");
        }

        $this->value = $intValue;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}