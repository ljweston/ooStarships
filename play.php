<?php

// __DIR__ is a constant pointing to our directory
// only calling the ship class once from the file
require_once __DIR__.'/lib/ship.php';

function printShipSummary($someShip)
{
    echo 'Ship name: '.$someShip->name;
    // echo 'IT\S A TRAAAAAPPPP!!!';
    echo '<hr/>';
    $someShip->sayHello();
    echo '<hr/>';
    echo $someShip->getName();
    echo '<hr/>';
    echo $someShip->getNameAndSpecs(false);
    echo '<hr/>';
    echo $someShip->getNameAndSpecs(true);
}
// new tells php Ship is a class.
$myShip = new Ship();
$myShip->name = 'Jedi Starship';
$myShip->weaponPower = 10;

$otherShip = new Ship();
$otherShip->name = 'Imperial Shuttle';
$otherShip->weaponPower = 50;

printShipSummary($myShip);

if ($myShip->givenShipMoreStrength($otherShip)) {
    echo $otherShip->name.'  has more strength';
} else {
    echo $myShip->name.'  has more strength';
}
