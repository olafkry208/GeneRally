<?php
declare(strict_types=1);

use Kryus\GeneRally\Track;

require_once 'vendor/autoload.php';

$trackname = $_SERVER['argv'][1];

$track = Track::createFromFile(__DIR__ . '/' . $trackname);

$landmapRenderer = new Track\TrackData\Landmap\Renderer\GdRenderer($track->getTrackData()->getLandmap());
$landmapRenderer->saveAsBmp(__DIR__ . '/' . $trackname . '_LMap.bmp');

$track->getTrackData()->getHeightmap()->toImage()->save(__DIR__ . '/' . $trackname . '_HMap.bmp');

ob_start();
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
<img src="<?php echo $landmapRenderer->toDataUri(); ?>">
<table>
    <?php foreach ($track->getTimeData()->getBestTimes() as $i => $bestTime) { ?>
        <tr>
            <th><?php echo $i === 0 ? 'TR' : "{$i}."; ?></th>
            <td><?php echo $bestTime->getLapTime(); ?></td>
            <td><?php echo $bestTime->getDriverName(); ?></td>
            <td><?php echo $bestTime->getDateTime()->format('Y-m-d H:i:s.v T'); ?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
<?php
file_put_contents(__DIR__ . '/' . $trackname . '.html', ob_get_clean());
