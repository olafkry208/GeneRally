<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track;

use Kryus\Binary\DataType\Word;
use Kryus\GeneRally\Track\Header\Version;

class Header
{
    /** @var string */
    private $headerString;

    /** @var Version */
    private $version;

    /**
     * @param Word $version
     * @param string $headerString
     * @throws \Exception
     */
    public function __construct(Word $version, string $headerString)
    {
        if ($headerString !== 'GR') {
            throw new \Exception("Invalid file header: “GR” expected, got “{$headerString}”.");
        }

        $this->headerString = $headerString;
        $this->version = new Version($version);
    }

    public function __toString()
    {
        return $this->headerString . $this->version->__toString();
    }

    /**
     * @return Version
     */
    public function getVersion(): Version
    {
        return $this->version;
    }
}