<?php
require __DIR__.'/bootstrap.php';

require 'bootstrap.php';
// file to create, validate, and save to the database.
use Service\Container;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $errors[] = 'This ship needs a name';
    }

    if (!empty($_POST['weapon-power'])) {
        $weaponPower = $_POST['weapon-power'];
    } else {
        $weaponPower = 0;
    }

    if (!empty($_POST['jedi-factor'])) {
        $jediFactor = $_POST['jedi-factor'];
    } else {
        $jediFactor = 0;
    }

    if (!empty($_POST['strength'])) {
        $strength = $_POST['strength'];
    } else {
        $strength = 0;
    }

    if (!empty($_POST['team'])) {
        $team = $_POST['team'];
    } else {
        $errors[] = 'All ships must have an allegiance';
    }

    if (count($errors) == 0) {
        $newShip = [
            'name'=> $name,
            'weapon_power'=> $weaponPower,
            'jedi_factor'=> $jediFactor,
            'strength'=> $strength,
            'team'=> $team,
        ];

    $container = new Container($configuration);
    $shipLoader = $container->getShipLoader();
    $shipLoader->saveShip($newShip);

    header('Location: /');
    die;
    }

}

// create a newShip object to pass to the DB from the below form. 

require 'layout/header.php';
?>

<div class="container">
    <ul class="breadcrumb">
        <li><a href="/index.php">Home</a></li>
        <li><a href="/manageShips.php">ManageShips</a></li>
        <li>Add ship</li>
    </ul>
    <div class="row">
        <div class="col-xs-6">
            <h1>Add a new ship</h1>
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
            <form action="/newShip.php" method="POST">
                <div class="form-group">
                    <label for="ship-name">Ship Name</label>
                    <input type="text" name="name" id="ship-name">
                </div>
                <div class="form-group">
                    <label for="ship-weapon-power">Weapon Power</label>
                    <input type="text" name="weapon-power" id="ship-weapon-power">
                </div>
                <div class="form-group">
                    <label for="ship-jedi-factor">Jedi Factor</label>
                    <input type="text" name="jedi-factor" id="ship-jedi-factor">
                </div>
                <div class="form-group">
                    <label for="ship-strength">Strength</label>
                    <input type="text" name="strength" id="ship-strength">
                </div>
                <div class="form-group">
                    <label for="ship-team">Ship Allegiance</label>
                    <select name="team" id="ship-team">
                        <option value="rebel">Rebel Ship</option>
                        <option value="empire">Empire Ship</option>
                    </select>
                </div>

                <button btn btn-primary><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>
