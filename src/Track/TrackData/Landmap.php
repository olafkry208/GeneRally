<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData;

use Imagine\Image\AbstractImage;
use Imagine\Image\ImageInterface;
use Kryus\GeneRally\DataType\Word;
use Kryus\GeneRally\Track\TrackData\Landmap\Pixel;

class Landmap
{
    /** @var int */
    private const WIDTH = 512;

    /** @var int */
    private const HEIGHT = 512;

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

    public function toImage(): ImageInterface
    {
        $imagine = new \Imagine\Gd\Imagine();

        $size = new \Imagine\Image\Box(self::WIDTH, self::HEIGHT);
        $image = $imagine->create($size);

        foreach ($this->pixels as $pixel) {
            $position = new \Imagine\Image\Point($pixel->getX(), $pixel->getY());
            $color = new \Imagine\Image\Palette\Color\RGB(new \Imagine\Image\Palette\RGB(), $pixel->getColor(), 100);

            $image->draw()->dot($position, $color);
        }

        return $image;
    }
}