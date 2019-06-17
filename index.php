<?php
declare(strict_types=1);

use Kryus\GeneRally\Track;

require_once 'vendor/autoload.php';

$trackname = $_SERVER['argv'][1];

$track = Track::createFromFile(__DIR__ . '/' . $trackname);

$landmapRenderer = new Track\TrackData\Landmap\Renderer\GdRenderer($track->getTrackData()->getLandmap());
$landmapRenderer->saveAsBmp(__DIR__ . '/' . $trackname . '_LMap.bmp');

$track->getTrackData()->getHeightmap()->toImage()->save(__DIR__ . '/' . $trackname . '_HMap.bmp');

file_put_contents(
    __DIR__ . '/' . $trackname . '.html',
    '<!DOCTYPE html><html><head></head><body><img src="' . $landmapRenderer->toDataUri() . '"></body></html>'
);
