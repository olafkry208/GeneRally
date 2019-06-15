<?php
declare(strict_types=1);

namespace Kryus\GeneRally\DataType;

class BinaryValue
{
    /** @var int[] */
    private $value;

    /** @var int */
    private $endianness;

    /** @var bool */
    private $signed;

    /**
     * @param string $value
     * @param int $endianness
     * @param bool $signed
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = ByteStream::ENDIANNESS_LITTLE_ENDIAN, bool $signed = false)
    {
        if (!in_array($endianness, [ByteStream::ENDIANNESS_LITTLE_ENDIAN, ByteStream::ENDIANNESS_BIG_ENDIAN], true)) {
            throw new \Exception('Invalid endianness type.');
        }

        foreach (str_split($value) as $char) {
            $this->value[] = ord($char);
        }

        $this->endianness = $endianness;
        $this->signed = $signed;
    }

    protected function getValue(): array
    {
        return $this->value;
    }

    protected function getEndianness(): int
    {
        return $this->endianness;
    }

    public function toInt(): int
    {
        $value = 0;
        $byteCount = count($this->value);

        if ($this->endianness === ByteStream::ENDIANNESS_BIG_ENDIAN) {
            for ($i = 0; $i < $byteCount; ++$i) {
                $value *= 256;
                $value += $this->value[$i];
            }
        } else {
            for ($i = $byteCount - 1; $i >= 0; --$i) {
                $value *= 256;
                $value += $this->value[$i];
            }
        }

        if ($this->signed) {
            $maxSignedValue = (1 << (8 * $byteCount - 1)) - 1;

            if ($value > $maxSignedValue) {
                $value = ($maxSignedValue + 1) * 2 - $value;
            }
        }

        return $value;
    }

    public function toHex(): string
    {
        return implode('', array_map('dechex', $this->value));
    }

    public function toBin(): string
    {
        return implode('', array_map('decbin', $this->value));
    }

    public function __toString()
    {
        return implode('', array_map('chr', $this->value));
    }
}