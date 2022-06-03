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
        $statement = $pdo->prepare('SELECT * FROM heroes');
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
        $statement = $pdo->prepare('SELECT * FROM heroes WHERE id = :id');
        // preapared statement
        $statement->execute(array('id' => $id));
        // $statement->bindParam()
        $heroArray = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($heroArray == false) {
            return null;
        }

        return $heroArray;
    }
}
