<?php

namespace Service;

use Model\Hero;
use Model\HeroCollection;

class HeroLoader{
    
    private $heroStorage;

    public function __construct(PdoHeroStorage $heroStorage)
    {
        $this->heroStorage = $heroStorage;
    }

    /**
     * @return ShipCollection
     */
    public function getHeroes()
    {
        $heroes = [];

        $heroesData = $this->queryForHeroes();

        foreach ($heroesData as $heroData) {
            $heroes[] = $this->createHeroFromData($heroData);
        }

        return new HeroCollection($heroes);
    }

    private function queryForHeroes()
    {
        try {
            return $this->heroStorage->fetchAllHeroesData();
        } catch (\PDOException $e) {
            trigger_error('Database Exception! '.$e->getMessage());
            // if all else fails, just return an empty array
            return [];
        }
    }

    private function createHeroFromData(array $heroData)
    {
        $hero = new Hero($heroData['name']); 
        $hero->setId($heroData['id']);
        $hero->setJediFactor($heroData['jedi_factor']);
        $hero->getTeam($heroData['team']);
        // set a currentHealth
        return $hero;
    }
}
