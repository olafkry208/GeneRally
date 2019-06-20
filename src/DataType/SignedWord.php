<?php
declare(strict_types=1);

namespace Kryus\GeneRally\DataType;

class SignedWord extends BinaryValue
{
    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = BinaryValue::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== 2) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Signed Word.");
        }

        parent::__construct($value, $endianness, true);
    }
}