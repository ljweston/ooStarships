<?php

namespace Service;

use Model\Hero;

class HeroLoader{
    
    private $heroStorage;

    public function __construct(PdoHeroStorage $heroStorage)
    {
        $this->heroStorage = $heroStorage;
    }

    /**
     * @return Hero[]
     */
    public function getHeroes()
    {
        $heroes = [];

        $heroesData = $this->queryForHeroes();

        foreach ($heroesData as $heroData) {
            $heroes[] = $this->createHeroFromData($heroData);
        }

        return $heroes;
    }

    /**
     * @param $id
     * @return Hero|null
     */
    public function findOneById($id)
    {
        $heroArray = $this->heroStorage->fetchSingleHeroData($id);
        if ($heroArray === null) {
            return null;
        }
        
        return $this->createHeroFromData($heroArray);
    }

    public function saveHero(Hero $hero)
    {
        $this->heroStorage->saveHero($hero);
    }

    public function updateHero(Hero $hero)
    {
        $this->heroStorage->updateHero(($hero));
    }

    public function deleteHero(Hero $hero)
    {
        $this->heroStorage->deleteHero($hero);
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
        $hero->setTeam($heroData['team']);
        return $hero;
    }
}
