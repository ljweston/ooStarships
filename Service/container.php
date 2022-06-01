<?php
/**
 * Class for handling service class objs creation.
 * Avoid code duplication
 * 
 * Known as a dependency container
 */

namespace Service;

use \PDO; // built in PDO object referenced in root

class Container
{
    private $configuration;

    private $pdo;

    private $shipLoader;

    private $shipStorage;

    private $battleManager;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
    * @return PDO
    */
    public function getPDO()
    {
        // check for PDO obj to avoid multiple connections
        if($this->pdo === null) {
            $this->pdo = new PDO(
                $this->configuration['db_dsn'],
                $this->configuration['db_user'],
                $this->configuration['db_pass']
            );
            // displays mysql errors we normally miss
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $this->pdo;
    }
    /**
     * @return ShipLoader
     */
    public function getShipLoader()
    {
        if ($this->shipLoader === null) {
            $this->shipLoader = new ShipLoader($this->getShipStorage());
        }

        return $this->shipLoader;
    }

    public function getShipStorage()
    {
        if ($this->shipStorage === null) {
            $this->shipStorage = new PdoShipStorage($this->getPDO());
            // $this->shipStorage = new JsonFileShipStorage(__DIR__.'/../../resources/ships.json');
            // $this->shipStorage = new LoggableShipStorage($this->shipStorage);
        }
        
        return $this->shipStorage;
    }

    /**
     * @return BattleManager
     */
    public function getBattleManager()
    {
        if ($this->battleManager === null) {
            $this->battleManager = new BattleManager();
        }

        return $this->battleManager;
    }
}
