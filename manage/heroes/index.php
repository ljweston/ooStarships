<?php
require '../layout/header.php';

use Service\Container;

$container = new Container($configuration);

$heroLoader = $container->getShipLoader();
$heroes = $heroLoader->getShips();
