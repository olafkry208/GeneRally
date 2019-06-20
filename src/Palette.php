<?php
declare(strict_types=1);

namespace Kryus\GeneRally;

use Kryus\GeneRally\Palette\Color;

class Palette
{
    /** @var Color[] */
    private $colors;

    /**
     * @param string[] $colors
     */
    public function __construct(array $colors)
    {
        $this->colors = $colors;
    }

    /**
     * @param string $filename
     * @return Palette
     */
    public static function createFromFilename(string $filename): Palette
    {
        $file = file_get_contents($filename);
        $colors = [];

        //TODO

        return new self($colors);
    }

    /**
     * @return Color[]
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @param int $id
     * @return Color|null
     */
    public function getColor(int $id): ?string
    {
        return $this->colors[$id] ?? null;
    }
}