<?php

require '../layout/header.php';

use Service\Container;

$id = isset($_GET['id']) ? $_GET['id'] : null;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
// get our ship
$ship = $shipLoader->findOneById($id);
$ship->repairShip(); // updated currenthealth on the ship obj
$shipLoader->repairShip($ship);

header('Location: /manage/ships/index.php');
