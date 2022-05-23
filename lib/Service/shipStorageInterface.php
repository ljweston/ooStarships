<?php
namespace Service;

// Can be passed around and won't worry about the object that is returned
interface ShipStorageInterface
{
    /**
     * Returns an array of ship arrays, with keys: id, name, weaponPOW, etc
     * @return array
     */
    public function fetchAllShipsData();

    /**
     * @param integer $id
     * @return array()
     */
    public function fetchSingleShipData($id);
}