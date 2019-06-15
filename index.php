<?php
declare(strict_types=1);

use Kryus\GeneRally\Track;

require_once 'vendor/autoload.php';

$trackname = $_SERVER['argv'][1];

$track = Track::createFromFile(__DIR__ . '/' . $trackname);
$track->getTrackData()->getLandmap()->toImage()->save(__DIR__ . '/' . $trackname . '_LMap.bmp');
$track->getTrackData()->getHeightmap()->toImage()->save(__DIR__ . '/' . $trackname . '_HMap.bmp');
