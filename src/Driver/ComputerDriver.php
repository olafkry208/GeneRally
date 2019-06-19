<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Driver;

use Kryus\GeneRally\Driver;

class ComputerDriver extends Driver
{
    /** @var AiLevel */
    private $aiLevel;

    /**
     * @param Colors $colors
     * @param Statistics $statistics
     * @param AiLevel $aiLevel
     */
    public function __construct(Colors $colors, Statistics $statistics, AiLevel $aiLevel)
    {
        parent::__construct($colors, $statistics);
        $this->aiLevel = $aiLevel;
    }

    public function getType(): int
    {
        return self::TYPE_COMPUTER;
    }

    /**
     * @return AiLevel
     */
    public function getAiLevel(): AiLevel
    {
        return $this->aiLevel;
    }
}