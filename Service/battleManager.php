<?php

namespace Service;

use Model\BattleResult;
use Model\AbstractShip;

class BattleManager
{
    // CLASS CONSTANTS
    const TYPE_NORMAL = 'type_normal';
    const TYPE_NO_JEDI = 'no_jedi';
    const TYPE_ONLY_JEDI = 'only_jedi';
        /**
         * Fighting algorithm
         * 
         * @return BattleResult
         */
        public function battle(AbstractShip $ship1, int $ship1Quantity, AbstractShip $ship2, int $ship2Quantity, $battleType)
        {
            /**
             * TODO: health management
             * 
             * set currentHealth = to the maxHealth/ check the currentVal and repair status
             * 
             * TODODO: Battle status. Display battle data as it occurs
             */
            
            $ship1Health = $ship1->getMaxHealth() * $ship1Quantity;
            $ship2Health = $ship2->getMaxHealth() * $ship2Quantity;

            $ship1UsedJediPowers = false;
            $ship2UsedJediPowers = false;
            $i = 0;
            while ($ship1Health > 0 && $ship2Health > 0) {
                // first, see if we have a rare Jedi hero event!
                if ($battleType != self::TYPE_NO_JEDI && $this->didJediDestroyShipUsingTheForce($ship1)) {
                    $ship2Health = 0;
                    $ship1UsedJediPowers = true;

                    break;
                }
                if ($battleType != self::TYPE_NO_JEDI && $this->didJediDestroyShipUsingTheForce($ship2)) {
                    $ship1Health = 0;
                    $ship2UsedJediPowers = true;

                    break;
                }

                if ($battleType != self::TYPE_ONLY_JEDI) {
                    // now battle them normally
                    $ship1Health = $ship1Health - ($ship2->getWeaponPower() * $ship2Quantity);
                    $ship2Health = $ship2Health - ($ship1->getWeaponPower() * $ship1Quantity);
                }

                if ($i == 100) {
                    $ship1Health = 0;
                    $ship2Health = 0;
                }
                $i++;
            }
            /**
             * Below logic will change to use the "currentHealth" data.
             * Will need to track damage above and change is below on each pass.
             */
            // We are now effecting/ changing data PASS BY REFERENCE
            $ship1->setMaxHealth($ship1Health);
            $ship2->setMaxHealth($ship2Health);

            if ($ship1Health <= 0 && $ship2Health <= 0) {
                // they destroyed each other
                $winningShip = null;
                $losingShip = null;
                $usedJediPowers = $ship1UsedJediPowers || $ship2UsedJediPowers;
            } elseif ($ship1Health <= 0) {
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
        private function didJediDestroyShipUsingTheForce(AbstractShip $ship)
        {
            $jediHeroProbability = $ship->getJediFactor() / 100;

            return mt_rand(1, 100) <= ($jediHeroProbability*100);
        }
}
