<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track\TimeData;

use Kryus\GeneRally\Track\TimeData\Ghost\Node;

class Ghost
{
    /** @var LapTime */
    private $lapTime;

    /** @var Node[] */
    private $frames;

    /** @var string */
    private $checksum;

    /**
     * @param LapTime $lapTime
     * @param array $frames
     * @param string $checksum
     */
    public function __construct(LapTime $lapTime, array $frames, string $checksum)
    {
        $this->lapTime = $lapTime;
        $this->frames = $frames;
        $this->checksum = $checksum; //TODO - add checksum verification
    }
}