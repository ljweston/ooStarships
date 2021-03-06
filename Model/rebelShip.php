<?php

namespace Model;

class RebelShip extends AbstractShip
{

    public function getFavoriteJedi()
    {
        $coolJedis = array('Yoda', 'Ben Kenobi');
        $key = array_rand($coolJedis);
        return $coolJedis[$key];
    }

    public function getType()
    {
        return AbstractShip::REBEL;
        // return $this->type;
    }

    public function isFunctional()
    {
        return $this->getCurrentHealth() > ((10/100) * $this->getMaxHealth());
    }

    public function getNameAndSpecs($useShortFormat = false)
    {
        $val = parent::getNameAndSpecs($useShortFormat);
        $val .= ' (Rebel)';

        return $val;
    }
}
