<?php
require_once "autoload.php";
$lighting = new Lighting();

if (isset($_GET['id'], $_GET['status'])) {
    $lighting->changeStatus($_GET['id'], $_GET['status']);
}

header("Location: index.php");
exit;
