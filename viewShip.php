<?php
require __DIR__.'/bootstrap.php';
// page to display a single ship data with the options to:
// ADD, EDIT, DELETE
use Service\Container;



$id = $_GET['id'];

// Need shiploader obj for ship
$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ship = $shipLoader->findOneById($id); // values may be getting changed here

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
                        <th class="col-1">Name:</th>
                        <td><?php echo $ship->getName()?></td>
                    </tr>
                    <tr class="d-flex">
                        <th class="col-1">Weapon Power:</th>
                        <td><?php echo $ship->getWeaponPower()?></td>
                    </tr>
                    <tr class="d-flex">
                        <th class="col-1">Strength:</th>
                        <td><?php echo $ship->getStrength()?></td>
                    </tr>
                    <tr class="d-flex">
                        <th class="col-1">Jedi Power:</th>
                        <td><?php echo $ship->getJediFactor()?></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <a href="" class="btn btn-md btn-success">Edit</a>
                <a href=""class="btn btn-md btn-danger">Delete</a>
            </div>
    </div>

<?php require 'layout/header.php'?>
