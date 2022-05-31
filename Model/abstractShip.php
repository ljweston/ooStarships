<?php

namespace Model;
// prevents instantiation of an AbstractShip object
abstract class AbstractShip
{
    const EMPIRE = 'empire';
    const REBEL = 'rebel';

    private $id;
    private $name;
    private $weaponPower = 0;
    private $strength = 0;

    abstract public function getJediFactor(); // forces extended class to have this method

    abstract public function setJediFactor($jediPower);
    
    abstract public function getType();

    abstract public function setType($team);

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
                $this->strength
            );
        } else {
            return sprintf(
                '%s: w:%s, j:%s, s:%s',
                $this->name,
                $this->weaponPower,
                $this->getJediFactor(),
                $this->strength
            );
        }
    }

    public function givenShipMoreStrength($givenShip)
    {
        // compare current ship to passed in ship
        return $givenShip->strength > $this->strength;
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
        if (!is_numeric($weaponPow)) {
            throw new \Exception('Invalid weapon power passed '.$weaponPow);
        }
        $this->weaponPower = $weaponPow;
    }

    public function setStrength($strength)
    {
        if (!is_numeric($strength)) {
            throw new \Exception('Invalid strength passed '.$strength);
        }
        $this-> strength = $strength;
    }

    public function getStrength()
    {
        return $this->strength;
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
