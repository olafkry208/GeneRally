<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData;

use Kryus\GeneRally\DataType\Word;
use Kryus\GeneRally\Track\TrackData\Landmap\Pixel;

class Landmap
{
    /** @var int */
    public const WIDTH = 512;

    /** @var int */
    public const HEIGHT = 512;

    /** @var Pixel[] */
    private $pixels = [];

    /**
     * @param Word[] $values
     * @throws \Exception
     */
    public function __construct(array $values)
    {
        $x = 0;
        $y = self::HEIGHT - 1;

        foreach ($values as $value) {
            $length = $value->getHighByte()->toInt() * 16 + $value->getLowByte()->getHighNibble();
            $surface = $value->getLowByte()->getLowNibble();

            for ($i = 0; $i < $length; ++$i) {
                $this->pixels[] = new Pixel($surface, $x, $y);

                ++$x;
                if ($x === self::WIDTH) {
                    $x = 0;
                    --$y;
                }
            }
        }
    }

    /**
     * @return Pixel[]
     */
    public function getPixels(): array
    {
        return $this->pixels;
    }
}