<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TrackData\Landmap\Renderer;

use Kryus\GeneRally\Track\TrackData\Landmap;
use Kryus\GeneRally\Track\TrackData\Landmap\Pixel;

class GdRenderer
{
    /** @var Landmap */
    private $landmap;

    /**
     * @param Landmap $landmap
     */
    public function __construct(Landmap $landmap)
    {
        $this->landmap = $landmap;
    }

    /**
     * @return resource
     */
    public function render()
    {
        $image = imagecreate(Landmap::WIDTH, Landmap::HEIGHT);

        $colors = [];
        for ($i = 0; $i < 16; $i++) {
            $color = Pixel::PIXEL_COLOR[$i];
            $colors[] = imagecolorallocate($image, $color[0], $color[1], $color[2]);
        }

        foreach ($this->landmap->getPixels() as $pixel) {
            imagesetpixel($image, $pixel->getX(), $pixel->getY(), $colors[$pixel->getSurface()]);
        }

        return $image;
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function saveAsBmp(string $filename): bool
    {
        return imagebmp($this->render(), $filename);
    }

    public function __toString()
    {
        ob_start();
        imagebmp($this->render());

        return (string)ob_get_clean();
    }

    /**
     * @return string
     */
    public function toDataUri()
    {
        return 'data:image/bmp;base64,' . base64_encode($this->__toString());
    }
}