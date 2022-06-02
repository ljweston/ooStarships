<?php

namespace Service;

use Model\RebelShip;
use Model\Ship;
use Model\AbstractShip;
use Model\ShipCollection;

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
     * @return ShipCollection
     */
    public function getShips()
    {
        $ships = array();

        $shipsData = $this->queryForShips();

        foreach ($shipsData as $shipData) {
            $ships[] = $this->createShipFromData($shipData);
        }

        return new ShipCollection($ships);
    }
    /**
     * @param $id
     * @return AbstractShip|null
     */
    public function findOneById($id)
    {
        $shipArray = $this->shipStorage->fetchSingleShipData($id);
        if ($shipArray === null) {
            return null;
        }
        
        return $this->createShipFromData($shipArray);
    }

    public function saveShip(AbstractShip $ship)
    {
        $this->shipStorage->saveShip($ship);
    }

    public function updateShip(AbstractShip $ship)
    {
        $this->shipStorage->updateShip($ship);
    }

    public function repairShip(AbstractShip $ship)
    {
        $this->shipStorage->repairShip($ship);
    }
    public function deleteShip(AbstractShip $ship)
    {
        $this->shipStorage->deleteShip($ship);
    }

    // RebelShip threw an error where it's RebelShip was assumed to be in the Service namespace
    private function createShipFromData(array $shipData)
    {
        if ($shipData['team'] == 'rebel') {
            $ship = new RebelShip($shipData['name']); 
        } else {
            $ship = new Ship($shipData['name']);
            
        }
        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setJediFactor($shipData['jedi_factor']);
        $ship->setMaxHealth($shipData['max_health']);
        $ship->setCurrentHealth($shipData['current_health']);
        // set a currentHealth
        return $ship;
    }

    private function queryForShips()
    {
        try {
            return $this->shipStorage->fetchAllShipsData();
        } catch (\PDOException $e) {
            trigger_error('Database Exception! '.$e->getMessage());
            // if all else fails, just return an empty array
            return [];
        }
    }
}
