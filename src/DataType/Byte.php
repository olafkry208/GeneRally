<?php
declare(strict_types=1);

namespace Kryus\GeneRally\DataType;

class Byte extends BinaryValue
{
    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = BinaryValue::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== 1) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Byte.");
        }

        parent::__construct($value, $endianness);
    }

    public function getHighNibble(): int
    {
        $value = $this->toInt();

        return ($value >> 4) % 16;
    }

    public function getLowNibble(): int
    {
        $value = $this->toInt();

        return $value % 16;
    }
}