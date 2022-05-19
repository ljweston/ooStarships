<?php


class ShipLoader
{
    // service class property: used to store options and objs for the class
    private $pdo;

    // configure db data
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return Ship[]
     */
    public function getShips()
    {
        // returns our data from the DB
        $shipsData = $this->queryForShips();
        // storing our ships in the ships array
        $ships = [];
        foreach ($shipsData as $shipData) {
            $ships[] = $this->createShipFromData($shipData);
        }
        
        return $ships;
    }
    /**
     * @return Ship/null
     */
    public function findOneById($id)
    {
        $pdo = $this->getPDO();
        $statement = $pdo->prepare('SELECT * FROM ship WHERE id = :id');
        // preapared statement
        $statement->execute(array('id' => $id));
        // $statement->bindParam()
        $shipArray = $statement->fetch(PDO::FETCH_ASSOC);

        if ($shipArray == false) {
            return null;
        }

        return $this->createShipFromData($shipArray);
    }

    private function createShipFromData(array $shipData)
    {
        if ($shipData['team'] == 'rebel') {
            $ship = new Ship($shipData['name']);
        } else {
            $ship = new Ship($shipData['name']);
        }
        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setJediFactor($shipData['jedi_factor']);
        $ship->setStrength($shipData['strength']);

        return $ship;
    }

    private function queryForShips()
    {
        $pdo = $this->getPDO();
        $statement = $pdo->prepare('SELECT * FROM ship');
        $statement->execute();
        $shipsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $shipsArray;
    }

    // reduce number of pdo objects created
    private function getPDO()
    {
        return $this->pdo;
    }

    // if ($this->pdo === null) {
    //     $pdo = new PDO($this->dbDSN, $this->dbUser, $this->dbPass);
    //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //     $this->pdo = $pdo;
    // }
}