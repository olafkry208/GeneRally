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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track reading demo</title>
</head>
<body>
<div style="display: flex;">
    <div style="flex: 1;">
        <img src="<?php echo $landmapRenderer->toDataUri(); ?>" style="transform: perspective(1024px) rotateX(<?php echo $track->getTrackData()->getProperties()->getViewAngle(); ?>deg) rotateZ(<?php echo $track->getTrackData()->getProperties()->getRotation(); ?>deg) scale(0.7071)">
    </div>
    <div style="flex: 1;">
        <table>
            <tr>
                <th>Version</th>
                <td><?php echo $track->getHeader()->getVersion(); ?></td>
            </tr>
        </table>
        <table>
            <caption>Track properties</caption>
            <tr>
                <th>Water level</th>
                <td><?php echo $track->getTrackData()->getProperties()->getWaterLevel(); ?></td>
            </tr>
            <tr>
                <th>View angle</th>
                <td><?php echo $track->getTrackData()->getProperties()->getViewAngle(); ?>&deg;</td>
            </tr>
            <tr>
                <th>Rotation</th>
                <td><?php echo $track->getTrackData()->getProperties()->getRotation(); ?>&deg;</td>
            </tr>
            <tr>
                <th>Zoom</th>
                <td><?php echo $track->getTrackData()->getProperties()->getZoom(); ?></td>
            </tr>
            <tr>
                <th>World size</th>
                <td><?php echo $track->getTrackData()->getProperties()->getWorldSize(); ?> m</td>
            </tr>
            <tr>
                <th>S/F line</th>
                <td><?php echo $track->getTrackData()->getProperties()->getSfLine()->toBool() ? 'Yes' : 'No'; ?></td>
            </tr>
            <tr>
                <th>Track length</th>
                <td><?php echo $track->getTrackData()->getProperties()->getTrackLength(); ?> m</td>
            </tr>
            <tr>
                <th>Author</th>
                <td><?php echo htmlspecialchars($track->getTrackData()->getProperties()->getAuthor()); ?></td>
            </tr>
            <tr>
                <th>Author's comments</th>
                <td><?php echo nl2br(htmlspecialchars($track->getTrackData()->getProperties()->getAuthorsComments())); ?></td>
            </tr>
        </table>
        <table>
            <caption>Track record</caption>
            <?php if ($track->getTimeData()->getTrackRecord() !== null) { ?>
                <tr>
                    <th></th>
                    <td><?php echo $track->getTimeData()->getTrackRecord()->getLapTime(); ?> s</td>
                    <td><?php echo htmlspecialchars($track->getTimeData()->getTrackRecord()->getDriverName()); ?></td>
                    <td><?php echo $track->getTimeData()->getTrackRecord()->getDateTime()->format('Y-m-d H:i:s.v T'); ?></td>
                </tr>
            <?php } ?>
        </table>
        <table>
            <caption>Best times</caption>
            <?php foreach ($track->getTimeData()->getBestTimes() as $i => $bestTime) { ?>
                <tr>
                    <th><?php echo $i; ?>.</th>
                    <td><?php echo $bestTime->getLapTime(); ?> s</td>
                    <td><?php echo htmlspecialchars($bestTime->getDriverName()); ?></td>
                    <td><?php echo $bestTime->getDateTime()->format('Y-m-d H:i:s.v T'); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>
<?php
file_put_contents(__DIR__ . '/' . $trackname . '.html', ob_get_clean());
