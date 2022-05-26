<?php

namespace Service;

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

    public function saveShipData($newShipData)
    {
        // connect to DB
        $pdo = $this->pdo;
        $query = 
            'INSERT INTO ship(name, weapon_power, jedi_factor, strength, team)
            VALUES(:nameVal, :weaponVal, :jediVal, :strengthVal, :teamVal)';
        $statement = $pdo->prepare($query);
        $statement->bindParam('nameVal', $newShipData['name']);
        $statement->bindParam('weaponVal', $newShipData['weapon_power']);
        $statement->bindParam('jediVal', $newShipData['jedi_factor']);
        $statement->bindParam('strengthVal', $newShipData['strength']);
        $statement->bindParam('teamVal', $newShipData['team']);
        // isFunctional data

        $statement->execute();

        // maybe return errors if any ecountered
    }
}
