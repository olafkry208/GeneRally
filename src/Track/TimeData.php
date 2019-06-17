<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track;

use Kryus\GeneRally\Track\TimeData\BestTime;
use Kryus\GeneRally\Track\TimeData\Ghost;

class TimeData
{
    /** @var BestTime[] */
    private $bestTimes;

    /** @var Ghost|null */
    private $ghost;

    /**
     * @param BestTime[] $bestTimes
     * @param Ghost $ghost
     */
    public function __construct(array $bestTimes, ?Ghost $ghost = null)
    {
        $this->bestTimes = $bestTimes;
        $this->ghost = $ghost;
    }

    /**
     * @return BestTime[]
     */
    public function getBestTimes(): array
    {
        return $this->bestTimes;
    }

    /**
     * @return Ghost|null
     */
    public function getGhost(): ?Ghost
    {
        return $this->ghost;
    }
}