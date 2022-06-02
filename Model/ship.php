<?php

namespace Model;
// Model Class
class Ship extends AbstractShip
{
    private $underRepair;

    public function __construct($name)
    {
        parent::__construct($name);
        
        $this->underRepair = mt_rand(1, 100) < 30;
    }

    public function getType()
    {
        return AbstractShip::EMPIRE;
    }

    // return if the ship is optional, we return the opposite for it's status for readability.
    public function isFunctional()
    {
        // check that the currentHealth is >= 15% of the maxHealth
        if ($this->getCurrentHealth() <= ((20/100) * $this->getMaxHealth())) {
            return false;
        } else {
            return true;
        }
    }
}
