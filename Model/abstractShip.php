<?php

namespace Model;
// MAYBE: Change this to an interface
// prevents instantiation of an AbstractShip object
abstract class AbstractShip
{
    const EMPIRE = 'empire';
    const REBEL = 'rebel';

    private $id;
    private $name;
    private $weaponPower = 0;
    private $maxHealth = 0;
    private $jediFactor = 0;
    private $currentHealth;
    
    abstract public function getType();

    abstract public function isFunctional();

    // constructor that is shared with extended classes
    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function getTeams()
    {
        return [self::EMPIRE, self::REBEL];
    }

    public function sayHello()
    {
        echo 'HELLO';
    }
    // getJediFactor may not be declared here, but it is inherited by ship and rebelship
    public function getNameAndSpecs($useShortFormat = false)
    {
        if ($useShortFormat) {
            return sprintf(
                '%s: %s/%s/%s',
                $this->name,
                $this->weaponPower,
                $this->getJediFactor(),
                $this->maxHealth
            );
        } else {
            return sprintf(
                '%s: w:%s, j:%s, s:%s',
                $this->name,
                $this->weaponPower,
                $this->getJediFactor(),
                $this->maxHealth
            );
        }
    }

    public function givenShipMoreHealth($givenShip)
    {
        // compare current ship to passed in ship
        return $givenShip->maxHealth > $this->maxHealth;
    }
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getWeaponPower()
    {
        return $this->weaponPower;
    }

    public function setWeaponPower($weaponPow)
    {
        $this->weaponPower = $weaponPow;
    }

    public function setMaxHealth($maxHealth)
    {
        $this-> maxHealth = $maxHealth;
    }

    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    public function getJediFactor()
    {
        return $this->jediFactor;
    }

    public function setJediFactor($jediPower)
    {
        $this->jediFactor = $jediPower;
    }
    // currentHealth tracking
    public function setCurrentHealth($currentHealth)
    {
        $this->currentHealth = $currentHealth;
    }

    public function getCurrentHealth()
    {
        return $this->currentHealth;
    }

    private function getSecretDoorCodeToTheDeathstar()
    {
        return 'Password';
    }

    public function __toString()
    {
        return $this->getName();
    }
}
