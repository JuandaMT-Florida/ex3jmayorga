<?php
require_once "autoload.php";
$lighting = new Lighting();

$zone = $_GET['zone'] ?? 'all';

$lighting->drawZonesOptions($zone);

$lamps = $lighting->getAllLamps($zone);
$lighting->drawLampsList($lamps);

echo "<h3>Potencia por zona (encendidas):</h3>";
$powerData = $lighting->getTotalPowerOn();
foreach ($powerData as $p) {
    echo "<div>{$p['zone_name']}: {$p['total_power']}W</div>";
}
