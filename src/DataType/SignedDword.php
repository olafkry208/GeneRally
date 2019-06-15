<?php
declare(strict_types=1);

namespace Kryus\GeneRally\DataType;

class SignedDword extends BinaryValue
{
    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = ByteStream::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== 4) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Signed Dword.");
        }

        parent::__construct($value, $endianness, true);
    }
}