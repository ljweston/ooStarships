<?php

namespace Service;

use Model\RebelShip;
use Model\Ship;
use Model\AbstractShip;

class ShipLoader
{
    // service class property: used to store options and objs for the class
    private $shipStorage;

    // configure DB Data or JSON File Data
    public function __construct(ShipStorageInterface $shipStorage)
    {
        $this->shipStorage = $shipStorage;
    }

    /**
     * @return AbstractShip[]
     */
    public function getShips()
    {
        // returns our data from the DB
        $shipsData = $this->shipStorage->fetchAllShipsData();
        // storing our ships in the ships array
        $ships = [];
        foreach ($shipsData as $shipData) {
            $ships[] = $this->createShipFromData($shipData);
        }
        
        return $ships;
    }
    /**
     * @param $id
     * @return AbstractShip|null
     */
    public function findOneById($id)
    {
        $shipArray = $this->shipStorage->fetchSingleShipData($id);

        return $this->createShipFromData($shipArray);
    }

    // RebelShip threw an error where it's RebelShip was assumed to be in the Service namespace
    private function createShipFromData(array $shipData)
    {
        if ($shipData['team'] == 'rebel') {
            $ship = new RebelShip($shipData['name']);
        } else {
            $ship = new Ship($shipData['name']);
            $ship->setJediFactor($shipData['jedi_factor']);
        }
        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setStrength($shipData['strength']);

        return $ship;
    }
}