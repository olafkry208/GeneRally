<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Ini;

class Replay
{
    /**
     * Memory required for replay can be calculated using following formula
     * mem_usage = 1800 * num_players * Length / FrameStep
     * Max duration of recorded replay (seconds). Default: 600
     *
     * @var int
     */
    private $length;

    /**
     * Record every FrameStepth frame. Default: 5
     *
     * @var int
     */
    private $frameStep;

    /**
     * @param int $length
     * @param int $frameStep
     */
    public function __construct(int $length = 600, int $frameStep = 5)
    {
        $this->length = $length;
        $this->frameStep = $frameStep;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getFrameStep(): int
    {
        return $this->frameStep;
    }
}