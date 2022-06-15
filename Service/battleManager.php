<?php
namespace Service;

use Model\BattleResult;
use Model\AbstractShip;
use Service\Container;

class BattleManager
{
    // CLASS CONSTANTS
    const TYPE_NORMAL = 'type_normal';
    const TYPE_NO_JEDI = 'no_jedi';
    const TYPE_ONLY_JEDI = 'only_jedi';

    private $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }
    /**
     * Fighting algorithm
     * 
     * @return BattleResult
     */
    public function battle(AbstractShip $ship1, int $ship1Quantity, AbstractShip $ship2, int $ship2Quantity, $battleType)
    {
        $container = new Container($this->configuration);
        $shipLoader = $container->getShipLoader();
        
        /**
         * TODO: health management
         * 
         * set currentHealth = to the maxHealth/ check the currentVal and repair status
         * 
         * TODODO: Battle status. Display battle data as it occurs
         */

        $ship1Health = $ship1->getCurrentHealth() * $ship1Quantity;
        $ship2Health = $ship2->getCurrentHealth() * $ship2Quantity;

        $ship1UsedJediPowers = false;
        $ship2UsedJediPowers = false;
        $i = 0;
        while ($ship1->isFunctional() && $ship2->isFunctional()) {
            // Can we use jedi powers?
            if ($battleType != self::TYPE_NO_JEDI && $this->didJediDestroyShipUsingTheForce($ship1)) {
                // Jedi powers destroyed ship2
                $ship2->setCurrentHealth(0);
                $ship1UsedJediPowers = true;

                break;
            }
            // can we use jedi powers?
            if ($battleType != self::TYPE_NO_JEDI && $this->didJediDestroyShipUsingTheForce($ship2)) {
                // Jedi powers destoryed ship1
                $ship1->setCurrentHealth(0);
                $ship2UsedJediPowers = true;

                break;
            }

            if ($battleType != self::TYPE_ONLY_JEDI) {
                // now battle them normally
                $ship1Health = $ship1Health - ($ship2->getWeaponPower() * $ship2Quantity);
                $ship2Health = $ship2Health - ($ship1->getWeaponPower() * $ship1Quantity);
            }
            // Should be able to remove this
            if ($i == 100) {
                $ship1Health = 0;
                $ship2Health = 0;
            }
            $i++;

            if ($ship1Health <= 0) {
                $ship1->setCurrentHealth(0);
            } else {
                $ship1->setCurrentHealth($ship1Health/$ship1Quantity);
            }
    
            if ($ship2Health<= 0) {
                $ship2->setCurrentHealth(0);
            } else {
                $ship2->setCurrentHealth($ship2Health/$ship2Quantity);
            }
        }
        /**
         * Below logic will change to use the "currentHealth" data.
         * Will need to track damage above and change is below on each pass.
         */
        // We are now effecting/ changing data PASS BY REFERENCE

        $shipLoader->updateShip($ship1);
        $shipLoader->updateShip($ship2);

        if (!$ship1->isFunctional() && !$ship2->isFunctional()) {
            // they destroyed each other
            $winningShip = null;
            $losingShip = null;
            $usedJediPowers = $ship1UsedJediPowers || $ship2UsedJediPowers;
        } elseif (!$ship1->isFunctional()) {
            $winningShip = $ship2;
            $losingShip = $ship1;
            $usedJediPowers = $ship2UsedJediPowers;
        } else {
            $winningShip = $ship1;
            $losingShip = $ship2;
            $usedJediPowers = $ship1UsedJediPowers;
        }
        // returns new object with ship objects
        return new BattleResult($usedJediPowers, $winningShip, $losingShip);
    }
    // only code effected is in this file.
    // TODO: May need better solution for how good the force is
    // Once heroes are implemented we will use the heroes modifiers + the ships base mods
    private function didJediDestroyShipUsingTheForce(AbstractShip $ship)
    {
        // check if passed in ship has a hero assigned
        if ($ship->getHero() != null) {
            // if there is a hero apply their bonus
            $jediHeroProbability = $ship->getJediFactor() + $ship->getHero()->getJediFactor() / 100;
        } else {
            $jediHeroProbability = $ship->getJediFactor() / 100;
        }
        var_dump($jediHeroProbability);
        return mt_rand(1, 100) <= ($jediHeroProbability*100);
    }
}
