<?php
require __DIR__.'/bootstrap.php';
// page to display a single ship data with the options to:
// ADD, EDIT, DELETE
use Service\Container;

// Check to make sure id has been set.
$id = isset($_GET['id']) ? $_GET['id'] : null;

// need to check if the ID exists

if ($id == null) {
    header('Location: /index.php?error=bad_id');
    die;
}
// Need shiploader obj for ship
$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
// check if the ID is valid. 
if ($shipLoader->findOneById($id) == null) {
    header('Location: /index.php?error=bad_id');
    die;
}

$ship = $shipLoader->findOneById($id);

if ($ship == null) {
    header('Location: /index.php?error=bad_ships');
    die;
}

require 'layout/header.php';

?>

    <div class="container">
            <div class="page-header">
                <h1>Viewing the <?php echo $ship->getName()?></h1>
            </div>
            <a href="/manageShips.php" class="btn btn-md btn-primary pull-right">Manage Ships</a>
            
            <table class="table table-striped">
                <tbody>
                    <tr class="d-flex">
                        <th style="width: 150px;">Name:</th>
                        <td style="width: 200px;"><?php echo $ship->getName()?></td>
                    </tr>
                    <tr class="d-flex">
                        <th class="">Weapon Power:</th>
                        <td><?php echo $ship->getWeaponPower()?></td>
                    </tr>
                    <tr class="d-flex">
                        <th class="">Strength:</th>
                        <td><?php echo $ship->getStrength()?></td>
                    </tr>
                    <tr class="d-flex">
                        <th class="">Jedi Power:</th>
                        <td><?php echo $ship->getJediFactor()?></td>
                    </tr>
                    <tr class="d-flex">
                        <th class="">Repair Status:</th>
                        <td>
                            <?php if ($ship->isFunctional()) : ?>
                                <i class="Fa fa-sun-o"></i>
                            <?php else : ?>
                                <i class="fa fa-cloud"></i>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div>
                <a href="" class="btn btn-md btn-success">Edit</a>
                <a href=""class="btn btn-md btn-danger">Delete</a>
            </div>
    </div>

<?php require 'layout/header.php'?>
