<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData;

use Imagine\Image\ImageInterface;
use Kryus\Binary\DataType\Byte;
use Kryus\GeneRally\Track\TrackData\Heightmap\Height;

class Heightmap
{
    /** @var int */
    public const WIDTH = 64;

    /** @var int */
    public const HEIGHT = 64;

    /** @var Height[] */
    private $heights = [];

    /**
     * @param Byte[] $values
     */
    public function __construct(array $values)
    {
        $x = 0;
        $y = self::HEIGHT - 1;

        foreach ($values as $value)
        {
            $this->heights[] = new Height($value, $x, $y);

            ++$x;
            if ($x === self::WIDTH) {
                $x = 0;
                --$y;
            }
        }
    }

    public function toImage(): ImageInterface
    {
        $imagine = new \Imagine\Gd\Imagine();

        $size = new \Imagine\Image\Box(self::WIDTH, self::HEIGHT);
        $image = $imagine->create($size);

        foreach ($this->heights as $height) {
            $position = new \Imagine\Image\Point($height->getX(), $height->getY());
            $color = new \Imagine\Image\Palette\Color\RGB(new \Imagine\Image\Palette\RGB(), $height->getColor(), 100);

            $image->draw()->dot($position, $color);
        }

        return $image;
    }
}