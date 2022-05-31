<?php

namespace Model;

class RebelShip extends AbstractShip
{
    private $jediFactor;

    public function getFavoriteJedi()
    {
        $coolJedis = array('Yoda', 'Ben Kenobi');
        $key = array_rand($coolJedis);
        return $coolJedis[$key];
    }

    public function getType()
    {
        return AbstractShip::REBEL;
    }

    public function isFunctional()
    {
        return true;
    }

    public function getNameAndSpecs($useShortFormat = false)
    {
        $val = parent::getNameAndSpecs($useShortFormat);
        $val .= ' (Rebel)';

        return $val;
    }

    public function getJediFactor()
    {
        return $this->jediFactor;
    }

    public function setJediFactor($jediPower)
    {
        $this->jediFactor = $jediPower;
    }
}
