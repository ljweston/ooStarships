<?php

require '../layout/header.php';

use Service\Container;

$id = isset($_GET['id']) ? $_GET['id'] : null;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ship = $shipLoader->findOneById($id);
if ($ship === null) {
    header('Location: /manage/ships/view.php');
}
$shipLoader->repairShip($ship);

header('Location: /manage/ships/view.php?id='.$id);
