<?php
// Model Class
class Ship
{
    private $id;
    private $name;
    private $weaponPower = 0;
    private $jediFactor = 0;
    private $strength = 0;

    private $underRepair;

    // constructor called everytime we call "SHIP" or a new instantiation
    public function __construct($name)
    {
        $this->name = $name;
        $this->underRepair = mt_rand(1, 100) < 30;
    }
    
    // return if the ship is optional, we return the opposite for it's status for readability.
    public function isFunctional()
    {
        return !$this->underRepair;
    }

    public function sayHello()
    {
        echo 'HELLO';
    }

    public function getNameAndSpecs($useShortFormat = false)
    {
        if ($useShortFormat) {
            return sprintf(
                '%s: %s/%s/%s',
                $this->name,
                $this->weaponPower,
                $this->jediFactor,
                $this->strength
            );
        } else {
            return sprintf(
                '%s: w:%s, j:%s, s:%s',
                $this->name,
                $this->weaponPower,
                $this->jediFactor,
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
            throw new Exception('Invalid weapon power passed '.$weaponPow);
        }
        $this->weaponPower = $weaponPow;
    }
    public function getJediFactor()
    {
        return $this->jediFactor;
    }

    public function setJediFactor($jediPow)
    {
        $this->jediFactor = $jediPow;
    }

    public function setStrength($strength)
    {
        if (!is_numeric($strength)) {
            throw new Exception('Invalid strength passed '.$strength);
        }
        $this-> strength = $strength;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function getType()
    {
        return 'Empire';
    }
}