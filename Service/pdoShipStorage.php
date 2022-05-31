<?php

namespace Service;

use Model\AbstractShip;

// service class to handle PDO queries for ships
class PdoShipStorage implements ShipStorageInterface
{
    private $pdo;

    // Dependency injection -> must pass in pdo obj
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array;
     */
    public function fetchAllShipsData()
    {
        $pdo = $this->pdo;
        $statement = $pdo->prepare('SELECT * FROM ship');
        $statement->execute();
        $shipsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        return $shipsArray;
    }

    /**
     * @return Ship[]|null
     */
    public function fetchSingleShipData($id)
    {
        $pdo = $this->pdo;
        $statement = $pdo->prepare('SELECT * FROM ship WHERE id = :id');
        // preapared statement
        $statement->execute(array('id' => $id));
        // $statement->bindParam()
        $shipArray = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($shipArray == false) {
            return null;
        }

        return $shipArray;
    }

    /**
     * @param AbstractShip
     * 
     * In this function you must create the fields as variables because bindParam passed by reference already.
     * Thus we cannot pass a function in as Functions CANNOT be passed by reference.
     */
    public function saveShipData($newShipData)
    {
        // connect to DB
        $pdo = $this->pdo;
        $query = 
            'INSERT INTO ship(name, weapon_power, jedi_factor, strength, team)
            VALUES(:nameVal, :weaponVal, :jediVal, :strengthVal, :teamVal)';
        $statement = $pdo->prepare($query);
        $name = $newShipData->getName();
        $statement->bindParam('nameVal', $name);
        $weaponPow = $newShipData->getWeaponPower();
        $statement->bindParam('weaponVal', $weaponPow);
        $jediFactor = $newShipData->getJediFactor();
        $statement->bindParam('jediVal', $jediFactor);
        $strength = $newShipData->getStrength();
        $statement->bindParam('strengthVal', $strength);
        $team = $newShipData->getType();
        $statement->bindParam('teamVal', $team);
        // isFunctional data

        $statement->execute();

        // maybe return errors if any ecountered
    }

    public function updateShipData($shipData)
    {
        $pdo = $this->pdo;
        $query = 
            'UPDATE OOPShips.ship
            SET name = :nameVal, weapon_power = :weaponVal, jedi_factor = :jediVal, strength = :strengthVal, team = :teamVal
            WHERE id = :idVal';
        $statement = $pdo->prepare($query);
        $name = $shipData->getName();
        $statement->bindParam('nameVal', $name);
        $weaponPow = $shipData->getWeaponPower();
        $statement->bindParam('weaponVal', $weaponPow);
        $jediFactor = $shipData->getJediFactor();
        $statement->bindParam('jediVal', $jediFactor);
        $strength = $shipData->getStrength();
        $statement->bindParam('strengthVal', $strength);
        $team = $shipData->getType();
        $statement->bindParam('teamVal', $team);
        $id = $shipData->getId();
        $statement->bindParam('idVal', $id);
        // isFunctional data

        $statement->execute();

        // maybe return errors if any ecountered
    }

    public function deleteShipData($id)
    {
        $pdo = $this->pdo;
        $query =
            'DELETE FROM ship WHERE id = :idVal';

        $statement = $pdo->prepare($query);
        $statement->bindParam('idVal', $id);

        $statement->execute();
    }
}
