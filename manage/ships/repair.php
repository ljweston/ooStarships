<?php

require '../layout/header.php';

use Service\Container;

$id = isset($_GET['id']) ? $_GET['id'] : null;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ship = $shipLoader->findOneById($id);
if ($ship === null) {
    echo '<h1>Ship Not Found</h1>';
    echo '<a href="/manage/ships/index.php">ManageShips</a>';
    die;
}

$shipLoader->repairShip($ship);
header('Location: /manage/ships/view.php?id='.$id);
?>

