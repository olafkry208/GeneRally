<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Driver;

use Kryus\GeneRally\Driver;

class HumanDriver extends Driver
{
    /** @var Controls */
    private $controls;

    /**
     * @param Colors $colors
     * @param Statistics $statistics
     * @param Controls $controls
     */
    public function __construct(Colors $colors, Statistics $statistics, Controls $controls)
    {
        parent::__construct($colors, $statistics);
        $this->controls = $controls;

    }

    public function getType(): int
    {
        return self::TYPE_HUMAN;
    }

    /**
     * @return Controls
     */
    public function getControls(): Controls
    {
        return $this->controls;
    }
}