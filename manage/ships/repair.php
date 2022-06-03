<?php

require '../layout/header.php';

use Service\Container;

$id = isset($_GET['id']) ? $_GET['id'] : null;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ship = $shipLoader->findOneById($id);
if ($ship != null) {
    $shipLoader->repairShip($ship);
    header('Location: /manage/ships/view.php?id='.$id);
}
?>

<div class="container">
        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/manage/ships/index.php">ManageShips</a></li>
            <li>Ship not found</li>
        </ul>
        <?php if ($ship === null): ?>
            <h1> Ship Not Found </h1>
        <?php endif;?>
</div>
