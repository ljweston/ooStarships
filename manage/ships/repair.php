<?php

require '../layout/header.php';

use Service\Container;

$id = isset($_GET['id']) ? $_GET['id'] : null;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();

$shipLoader->repairShip($id);

header('Location: /manage/ships/view.php?id='.$id);
