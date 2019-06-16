<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track;

use Kryus\GeneRally\Track\TimeData\BestTime;
use Kryus\GeneRally\Track\TimeData\Ghost;

class TimeData
{
    /** @var BestTime[] */
    private $trackTimes;

    /** @var Ghost|null */
    private $ghost;

    /**
     * @param BestTime[] $trackTimes
     * @param Ghost $ghost
     */
    public function __construct(array $trackTimes, ?Ghost $ghost = null)
    {
        $this->trackTimes = $trackTimes;
        $this->ghost = $ghost;
    }

    /**
     * @return BestTime[]
     */
    public function getTrackTimes(): array
    {
        return $this->trackTimes;
    }

    /**
     * @return Ghost|null
     */
    public function getGhost(): ?Ghost
    {
        return $this->ghost;
    }
}