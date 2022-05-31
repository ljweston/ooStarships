<?php 
// Display already entered data and allow uses to edit it. Doing similar checks to new

require '../layout/header.php';

use Model\AbstractShip;
use Service\Container;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$teams = AbstractShip::getTeams();
$errors = [];

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $id = $_POST['petId'];
//     $ship
// }

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $ship = $shipLoader->findOneById($id);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $ship = $shipLoader->findOneById($id);
}

var_dump($ship->getType())
?>

<div class="container">
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/manage/ships/index.php">ManageShips</a></li>
        <li><a href="/manage/ships/view.php?id=<?php echo $id;?>"><?php echo $ship->getName();?></a></li>
        <li>Editing <?php echo $ship->getName();?></li> 
    </ul>
    <div class="row">
        <div class="col-xs-6">
            <h1>Edit This Ship</h1>
            <?php if (count($errors) > 0) :?>
                <div class="alert alert-danger" role="alert">
                    <h3>ERROR - Please correct the following...</h3>
                    <ul>
                        <?php foreach ($errors as $error) : ?>                    
                            <li><?php echo $error . "<br />"; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="/manage/ships/edit.php" method="POST">
                <div class="form-group">
                    <label for="ship-name">Ship Name</label>
                    <input type="text" name="name" id="ship-name" value="<?php echo $ship->getName()?>">
                </div>
                <div class="form-group">
                    <label for="ship-weapon-power">Weapon Power</label>
                    <input type="text" name="weapon-power" id="ship-weapon-power" value="<?php echo $ship->getWeaponPower()?>">
                </div>
                <div class="form-group">
                    <label for="ship-jedi-factor">Jedi Factor</label>
                    <input type="text" name="jedi-factor" id="ship-jedi-factor" value="<?php echo $ship->getJediFactor()?>">
                </div>
                <div class="form-group">
                    <label for="ship-strength">Strength</label>
                    <input type="text" name="strength" id="ship-strength" value="<?php echo $ship->getStrength()?>">
                </div>
                <div class="form-group">
                    <label for="ship-team">Ship Allegiance</label>
                    <select name="team" id="ship-team">
                        <!-- loaded original/ saved value first -->
                        <option value="<?php echo $ship->getType()?>">
                        <?php echo ucfirst($ship->getType())." Ship"?>
                        </option>
                        <?php foreach ($teams as $team) : ?>
                            <option value="<?php echo $team?>">
                                <?php echo ucfirst($team)." Ship"?>
                            </option>
                        <?php endforeach; ?>
                        <option value="">-- Select One --</option>
                    </select>
                </div>

                <button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>
<?php require '../layout/footer.php'?>
