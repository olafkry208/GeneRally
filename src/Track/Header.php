<?php
declare(strict_types=1);

namespace Kryus\GeneRally\Track;

use Kryus\GeneRally\DataType\Dword;
use Kryus\GeneRally\Track\Header\Version;

class Header
{
    /** @var string */
    private $headerString;

    /** @var Version */
    private $version;

    public function __construct(Dword $value)
    {
        $this->headerString = $value->getHighWord()->__toString();
        $this->version = new Version($value->getLowWord());

        if ($this->headerString !== 'GR') {
            throw new \Exception("Invalid file header: “GR” expected, got “{$this->headerString}”.");
        }
    }

    public function __toString()
    {
        return $this->headerString . $this->version->__toString();
    }
}