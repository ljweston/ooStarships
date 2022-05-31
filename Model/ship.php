<?php

namespace Model;
// Model Class
class Ship extends AbstractShip
{
    private $jediFactor = 0;
    private $underRepair;
    private $type;

    public function __construct($name)
    {
        parent::__construct($name);
        
        $this->underRepair = mt_rand(1, 100) < 30;
    }

    public function getJediFactor()
    {
        return $this->jediFactor;
    }

    public function setJediFactor($jediPow)
    {
        $this->jediFactor = $jediPow;
    }

    public function getType()
    {
        // return AbstractShip::EMPIRE;
        return $this->type;
    }

    public function setType($team)
    {
        $this->type = $team;
    }

    // return if the ship is optional, we return the opposite for it's status for readability.
    public function isFunctional()
    {
        return !$this->underRepair;
    }
}
