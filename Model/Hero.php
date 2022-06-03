<?php

namespace Model;

class Hero
{
    private $id;
    private $name;
    private $jediFactor;
    private $team;

    public function __construct($name)
    {
        $this->name = $name;
    }

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

    public function getJediFactor()
    {
        return $this->jediFactor;
    }

    public function setJediFactor($jediFactor)
    {
        $this->jediFactor = $jediFactor;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function setTeam($team)
    {
        $this->team = $team;
    }

    public function getNameAndPower($useShortFormat = false)
    {
        if ($useShortFormat) {
            return sprintf(
                '%s: %s',
                $this->name,
                $this->jediFactor,
            );
        } else {
            return sprintf(
                '%s: j:%s',
                $this->name,
                $this->jediFactor,
            );
        }
    }
}
