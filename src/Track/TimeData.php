<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track;

use Kryus\GeneRally\Track\TimeData\BestTime;
use Kryus\GeneRally\Track\TimeData\Ghost;

class TimeData
{
    /** @var BestTime|null */
    private $trackRecord;

    /** @var BestTime[] */
    private $bestTimes;

    /** @var Ghost|null */
    private $ghost;

    /**
     * @param BestTime|null $trackRecord
     * @param BestTime[] $bestTimes
     * @param Ghost $ghost
     */
    public function __construct(?BestTime $trackRecord, array $bestTimes, ?Ghost $ghost = null)
    {
        $this->trackRecord = $trackRecord;
        $this->bestTimes = $bestTimes;
        $this->ghost = $ghost;
    }

    /**
     * @return BestTime|null
     */
    public function getTrackRecord(): ?BestTime
    {
        return $this->trackRecord;
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