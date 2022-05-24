<?php
require __DIR__.'/bootstrap.php';

use Service\BattleManager;
use Service\Container;

// $configuration comes from bootstrap.php
$container = new Container($configuration);

$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();

// Error checking for bad data passed to start a battle
$errorMessage = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'missing_data':
            $errorMessage = 'Don\'t forget to select some ships to battle!';
            break;
        case 'bad_ships':
            $errorMessage = 'You\'re trying to fight with a ship that\'s unknown to the galaxy?';
            break;
        case 'bad_quantities':
            $errorMessage = 'You picked a strange numbers of ships to battle - try again.';
            break;
        case 'bad_id':
            $errorMessage = 'Bad ship ID.';
            break;
        default:
            $errorMessage = 'There was a disturbance in the force. Try again.';
    }
}

require 'layout/header.php'; 
?>

    <?php if ($errorMessage): ?>
        <div>
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>
    
        <div class="container">
            <div class="page-header">
                <h1>OO Battleships of Space</h1>
            </div>
            <table class="table table-hover">
                <caption><i class="fa fa-rocket"></i> These ships are ready for their next Mission</caption>
                <a href="/manageShips.php" class="btn btn-md btn-primary pull-right">Manage Ships</a>
                <thead>
                    <tr>
                        <th>Ship</th>
                        <th>Weapon Power</th>
                        <th>Jedi Factor</th>
                        <th>Strength</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ships as $ship): ?>
                        <tr>
                            <td><?php echo $ship->getName(); ?></td>
                            <td><?php echo $ship->getWeaponPower(); ?></td>
                            <td><?php echo $ship->getJediFactor(); ?></td>
                            <td><?php echo $ship->getStrength(); ?></td>
                            <td><?php echo $ship->getType(); ?></td>
                            <td>
                                <?php if ($ship->isFunctional()) : ?>
                                    <i class="Fa fa-sun-o"></i>
                                <?php else : ?>
                                    <i class="fa fa-cloud"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="battle-box center-block border">
                <div>
                    <form method="POST" action="/battle.php">
                        <h2 class="text-center">The Mission</h2>
                        <input class="center-block form-control text-field" type="text" name="ship1_quantity" placeholder="Enter Number of Ships" />
                        <select class="center-block form-control btn drp-dwn-width btn-default dropdown-toggle" name="ship1_id">
                            <option value="">Choose a Ship</option>
                            <!-- Originally had $key=>$ship to iterate through the array of objs -->
                            <?php foreach ($ships as $ship): ?>
                                <?php if ($ship->isFunctional()) : ?>
                                <option value="<?php echo $ship->getId(); ?>"><?php echo $ship->getNameAndSpecs(true); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <p class="text-center">AGAINST</p>
                        <br>
                        <input class="center-block form-control text-field" type="text" name="ship2_quantity" placeholder="Enter Number of Ships" />
                        <select class="center-block form-control btn drp-dwn-width btn-default dropdown-toggle" name="ship2_id">
                            <option value="">Choose a Ship</option>
                            <?php foreach ($ships as $ship): ?>
                                <?php if ($ship->isFunctional()) : ?>
                                <option value="<?php echo $ship->getId(); ?>"><?php echo $ship->getNameAndSpecs(true); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <br>

                        <div class="text-center">
                            <label for="battle_type">Battle Type</label>
                            <select name="battle_type" id="battle_type" class="center-block form-control btn drp-dwn-width btn-default dropdown-toggle">
                                <option value="<?php echo BattleManager::TYPE_NORMAL?>">Normal</option>
                                <option value="<?php echo BattleManager::TYPE_NO_JEDI?>">No Jedi Powers</option>
                                <option value="<?php echo BattleManager::TYPE_ONLY_JEDI?>">Only Jedi Powers</option>
                            </select>
                        </div>
                        <br>

                        <button class="btn btn-md btn-danger center-block" type="submit">Engage</button>
                    </form>
                </div>
            </div>
        </div>

<?php require 'layout/footer.php'; ?>
