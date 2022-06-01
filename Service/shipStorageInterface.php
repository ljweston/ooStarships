<?php
namespace Service;

use Model\AbstractShip;

// Can be passed around and won't worry about the object that is returned
interface ShipStorageInterface
{
    /**
     * Returns an array of ship arrays, each with the following keys:
     *  * id
     *  * name
     *  * weapon_power
     *  * strength
     *  * team
     *
     * @return array
     */
    public function fetchAllShipsData();

    /**
     * Returns the single ship array for this id (see fetchAllShipsData)
     *
     * @param integer $id
     * @return array
     */
    public function fetchSingleShipData($id);

    /**
     * Returns nothing, just saves passed in ship data
     */
    public function saveShip(AbstractShip $newShip);

    public function updateShip(AbstractShip $ship);

    public function deleteShip(AbstractShip $ship);
}
