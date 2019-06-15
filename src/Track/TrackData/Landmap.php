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

    /**
     * @return resource
     */
    public function toImage()
    {
        $image = imagecreate(self::WIDTH, self::HEIGHT);

        $colors = [];
        for ($i = 0; $i < 16; $i++) {
            $color = Pixel::PIXEL_COLOR[$i];
            $colors[] = imagecolorallocate($image, $color[0], $color[1], $color[2]);
        }

        foreach ($this->pixels as $pixel) {
            imagesetpixel($image, $pixel->getX(), $pixel->getY(), $colors[$pixel->getSurface()]);
        }

        return $image;
    }
}