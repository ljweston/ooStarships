<?php
require __DIR__.'/bootstrap.php';
// page to display a single ship data with the options to:
// ADD, EDIT, DELETE
use Service\Container;

require 'layout/header.php';

$id = $_GET['id'];

// Need shiploader obj for ship
$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ship = $shipLoader->findOneById($id); // values may be getting changed here

echo $ship->getName();
