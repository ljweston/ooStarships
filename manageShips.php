<?php
require __DIR__.'/bootstrap.php';
// Page to manage and display a ship table and link to view ships alone
// for Edit/ Delete or Add ships

use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();

require 'layout/header.php';
?>

    <!-- Error handling -->

        <div class="container">
            <div class="page-header">
                <h1>Manage Our Ships</h1>
            </div>
            <table class="table table-hover">
                <caption><i class="fa fa-rocket"></i> View/ Edit These Ships</caption>
                <a href="index.php" class="btn btn-md btn-primary pull-right">Return Home</a>
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
                            <td><a href="viewShip.php?id=<?php echo $ship->getId();?>">
                            <?php echo $ship->getName(); ?></a></td>
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
        </div>

<?php require 'layout/footer.php';?>