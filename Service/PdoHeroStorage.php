<?php

namespace Service;

use Model\Hero;

class PdoHeroStorage
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

     /**
     * @return array;
     */
    public function fetchAllHeroesData()
    {
        $pdo = $this->pdo;
        $statement = $pdo->prepare('SELECT * FROM heroes ORDER BY name ASC');
        $statement->execute();
        $heroesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        return $heroesArray;
    }

    /**
     * @return Ship[]|null
     */
    public function fetchSingleHeroData($id)
    {
        $pdo = $this->pdo;
        $statement = $pdo->prepare('SELECT * FROM heroes WHERE hero_id = :id');
        // preapared statement
        $statement->execute(array('id' => $id));
        // $statement->bindParam()
        $heroArray = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($heroArray == false) {
            return null;
        }

        return $heroArray;
    }

    public function saveHero(Hero $hero)
    {
        $pdo = $this->pdo;
        $query = 
            'INSERT INTO heroes(name, jedi_factor, team)
            VALUES(:nameVal, :jediVal, :teamVal)';
        $statement = $pdo->prepare($query);
        $statement->bindValue('nameVal', $hero->getName());
        $statement->bindValue('jediVal', $hero->getJediFactor());
        $statement->bindValue('teamVal', $hero->getTeam());

        $statement->execute();
    }

    public function updateHero(Hero $hero)
    {
        $pdo = $this->pdo;
        $query = 
            'UPDATE OOPShips.heroes
            SET name = :nameVal, jedi_factor = :jediVal WHERE hero_id = :idVal';
        $statement = $pdo->prepare($query);
        $statement->bindValue('nameVal', $hero->getName());
        $statement->bindValue('jediVal', $hero->getJediFactor());
        $statement->bindValue('idVal', $hero->getId());

        $statement->execute();

        // maybe return errors if any ecountered
    }

    // delete by accepting the hero object and taking the id to find an item and delete
    public function deleteHero(Hero $hero)
    {
        $pdo = $this->pdo;
        $query = 
            'DELETE FROM heroes WHERE id = :idVal';
        
        $statement = $pdo->prepare($query);
        $statement->bindValue('idVal', $hero->getId());

        $statement->execute();
    }
}
