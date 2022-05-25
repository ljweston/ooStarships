<?php
require __DIR__.'/../../bootstrap.php';
// page to display a single ship data with the options to:
// ADD, EDIT, DELETE
use Service\Container;

// Check to make sure id has been set.
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Need shiploader obj for ship
$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
// check if the ID is valid. 
$ship = $shipLoader->findOneById($id);

require '../layout/header.php';

?>

    <div class="container">
        <ul class="breadcrumb">
            <li><a href="../../index.php">Home</a></li>
            <li><a href="manageShips.php">ManageShips</a></li>
            <li><?php echo $ship === null ? "Ship not found" : $ship->getName() ?></li>
        </ul>
        <?php if ($ship === null): ?>
            <h1> Ship Not Found </h1>
        <?php else: ?>
            <div class="page-header">
                <h1>Viewing the <?php echo $ship->getName()?></h1>
            </div>
            
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th style="width: 150px;">Name:</th>
                        <td><?php echo $ship->getName()?></td>
                    </tr>
                    <tr>
                        <th>Weapon Power:</th>
                        <td><?php echo $ship->getWeaponPower()?></td>
                    </tr>
                    <tr>
                        <th>Strength:</th>
                        <td><?php echo $ship->getStrength()?></td>
                    </tr>
                    <tr>
                        <th>Jedi Power:</th>
                        <td><?php echo $ship->getJediFactor()?></td>
                    </tr>
                    <tr>
                        <th>Repair Status:</th>
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
                <a href="#" class="btn btn-md btn-success">Edit</a>
                <a href="#" class="btn btn-md btn-danger">Delete</a>
            </div>
        <?php endif; ?>
    </div>
<?php require '../layout/footer.php'?>
