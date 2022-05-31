<?php
require '../layout/header.php';

// file to create, validate, and save to the database.

use Model\RebelShip;
use Model\Ship;
use Model\AbstractShip;
use Service\Container;

$teams = AbstractShip::getTeams();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    if (!empty($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $errors[] = 'This ship needs a name';
    }
    // numeric vals
    $weaponPower = $_POST['weapon-power'];
    if (empty($weaponPower)){
        $weaponPower = 0;
    } elseif (!is_numeric($weaponPower)) {
        $errors[] = 'Weapon power must be a number';
    }
    // numeric vals
    $jediFactor = $_POST['jedi-factor'];
    if (empty($jediFactor)) {
        $jediFactor = 0;
    } elseif (!is_numeric($jediFactor)){
        $errors[] = 'Jedi factor must be a number';
    }
    // change to be full health/ MAXHealth
    // check for empty and numeric values
    $strength = $_POST['strength'];
    if (empty($strength)) {
        $strength = 0;
    } elseif (!is_numeric($strength)) {
        $errors[] = 'Strength must be a number';
    }
    
    $team = $_POST['team'];
    if (empty($team)) {
        $errors[] = 'All ships must have an allegiance';
    } elseif (!in_array($team, $teams)) {
        $errors[] = 'Select a valid team';
    }

    if (count($errors) == 0) {
        // $newShip = [
        //     'name'=> $name,
        //     'weapon_power'=> $weaponPower,
        //     'jedi_factor'=> $jediFactor,
        //     'strength'=> $strength,
        //     'team'=> $team,
        // ];
        $container = new Container($configuration);
        $shipLoader = $container->getShipLoader();

        if ($team == 'rebel') {
            $newShip = new RebelShip($name);
        } else {
            $newShip = new Ship($name);
        }
        $newShip->setWeaponPower($weaponPower);
        $newShip->setJediFactor($jediFactor);
        $newShip->setStrength($strength);
        $newShip->setType($team);

        $shipLoader->saveShip($newShip);
        
        // not used in E3
        header('Location: /manage/ships/index.php');
        die;
    }

}

?>

<div class="container">
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/manage/ships/index.php">ManageShips</a></li>
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
            <form action="/manage/ships/new.php" method="POST">
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
                        <option value="">-- Select One --</option>
                        <?php foreach ($teams as $team) : ?>
                            <option value="<?php echo $team?>">
                                <?php echo ucfirst($team)." Ship"?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>
<?php require '../layout/footer.php'?>
