<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Ini;

class Viewport
{
    /**
     * Override Camera settings for all tracks. Defaults: default
     *
     * @var int|null
     */
    private $viewAngle;

    /**
     * Override Camera settings for all tracks. Defaults: default
     *
     * @var int|null
     */
    private $rotation;

    /**
     * Override Camera settings for all tracks. Defaults: default
     *
     * @var int|null
     */
    private $zoom;

    /**
     * @param int|null $viewAngle
     * @param int|null $rotation
     * @param int|null $zoom
     */
    public function __construct(?int $viewAngle = null, ?int $rotation = null, ?int $zoom = null)
    {
        $this->viewAngle = $viewAngle;
        $this->rotation = $rotation;
        $this->zoom = $zoom;
    }

    /**
     * @return int|null
     */
    public function getViewAngle(): ?int
    {
        return $this->viewAngle;
    }

    /**
     * @return int|null
     */
    public function getRotation(): ?int
    {
        return $this->rotation;
    }

    /**
     * @return int|null
     */
    public function getZoom(): ?int
    {
        return $this->zoom;
    }
}