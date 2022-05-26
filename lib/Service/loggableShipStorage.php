<?php

namespace Service;
// offloading our ship storage work
// works with any ship storage type like pdo or json.
class LoggableShipStorage implements ShipStorageInterface
{
    private $shipStorage;

    public function __construct(ShipStorageInterface $shipStorage)
    {
        $this->shipStorage = $shipStorage;
    }

    public function fetchAllShipsData()
    {
        $ships = $this->shipStorage->fetchAllShipsData();

        // $this->log(sprintf('Just fetched %s ships', count($ships)));

        return $ships;
    }

    public function fetchSingleShipData($id)
    {
        return $this->shipStorage->fetchSingleShipData($id);
    }

    public function saveShipData($newShipData)
    {
        return $this->shipStorage->saveShipData($newShipData);
    }

    private function log($message)
    {
        // do something intelligent
        echo $message;
    }
}
