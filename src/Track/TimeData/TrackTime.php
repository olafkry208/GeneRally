<?php
declare(strict_types=1);

namespace Kryus\GeneRally\TimeData;

use Kryus\GeneRally\Car;

class TrackTime
{
    /** @var float */
    private $time;

    /** @var string */
    private $name;

    /** @var Car */
    private $car;

    /** @var \DateTime */
    private $datetime;
}