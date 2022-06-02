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
     * In this function you must create the fields as variables because bindParam
     * accepts variables to then be passed by reference already.
     * Thus we cannot pass a function in as Functions CANNOT be passed by reference.
     */
    public function saveShip(AbstractShip $ship)
    {
        // connect to DB
        $pdo = $this->pdo;
        $query = 
            'INSERT INTO ship(name, weapon_power, jedi_factor, max_health, team, current_health)
            VALUES(:nameVal, :weaponVal, :jediVal, :maxHealthVal, :teamVal, :currentHealthVal)';
        $statement = $pdo->prepare($query);
        $statement->bindValue('nameVal', $ship->getName());
        $statement->bindValue('weaponVal', $ship->getWeaponPower());
        $statement->bindValue('jediVal', $ship->getJediFactor());
        $statement->bindValue('maxHealthVal', $ship->getMaxHealth());
        $statement->bindValue('teamVal', $ship->getType());
        $statement->bindValue('currentHealthVal', $ship->getCurrentHealth());
        // isFunctional data

        $statement->execute();

        // maybe return errors if any ecountered
    }

    public function repairShip(AbstractShip $ship)
    {
        $pdo = $this->pdo;
        $query = 'UPDATE OOPShips.ship SET current_health = :currentHealthVal WHERE id = :idVal';
        $statement = $pdo->prepare($query);
        $statement->bindValue('currentHealthVal', $ship->getCurrentHealth());
        $statement->bindValue('idVal', $ship->getId());
        
        $statement->execute();
    }

    public function updateShip(AbstractShip $ship)
    {
        $pdo = $this->pdo;
        $query = 
            'UPDATE OOPShips.ship
            SET name = :nameVal, weapon_power = :weaponVal, jedi_factor = :jediVal,
            max_health = :maxHealthVal, team = :teamVal, current_health = :currentHealthVal
            WHERE id = :idVal';
        $statement = $pdo->prepare($query);
        $statement->bindValue('nameVal', $ship->getName());
        $statement->bindValue('weaponVal', $ship->getWeaponPower());
        $statement->bindValue('jediVal', $ship->getJediFactor());
        $statement->bindValue('maxHealthVal', $ship->getMaxHealth());
        $statement->bindValue('teamVal', $ship->getType());
        $statement->bindValue('currentHealthVal', $ship->getCurrentHealth());
        $statement->bindValue('idVal', $ship->getId());
        // isFunctional data

        $statement->execute();

        // maybe return errors if any ecountered
    }

    public function deleteShip(AbstractShip $ship)
    {
        $pdo = $this->pdo;
        $query =
            'DELETE FROM ship WHERE id = :idVal';

        $statement = $pdo->prepare($query);
        $statement->bindValue('idVal', $ship->getId());

        $statement->execute();
    }
}
