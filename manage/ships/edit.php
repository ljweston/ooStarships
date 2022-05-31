<?php 
// Display already entered data and allow uses to edit it. Doing similar checks to new

require '../layout/header.php';

use Model\AbstractShip;
use Service\Container;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$teams = AbstractShip::getTeams();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // set the shipID and instantiate a ship
    if (isset($_POST['shipId'])) {
        $id = $_POST['shipId'];
        $ship = $shipLoader->findOneById($id);
        if ($ship == null) {
            echo 'SHIP NOT FOUND';
            die;
        }
    } else {
        throw new \Exception('NO SHIP WITH THIS ID FOUND');
        // or could catch and die the error
    }

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

    // check for the ID of the ship 

    if (count($errors) == 0) {
        // $shipData = [
        //     'name'=> $name,
        //     'weapon_power'=> $weaponPower,
        //     'jedi_factor'=> $jediFactor,
        //     'strength'=> $strength,
        //     'team'=> $team,
        //     'id'=> $id
        // ];

        $ship->setName($name);
        $ship->setWeaponPower($weaponPower);
        $ship->setJediFactor($jediFactor);
        $ship->setStrength($strength);
        $ship->setType($team); // may need to change the getType func.
        // team determines the type of ship created: ship or rebelShip.
        // Whatever returns from the DB lets us choose our instantiation of ship.

        $shipLoader->updateShip($ship);
        // not used in E3
        header('Location: /manage/ships/index.php');
        die;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $ship = $shipLoader->findOneById($id);
}

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

                <button class="btn btn-success" name="shipId" value="<?php echo $id?>"><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>
<?php require '../layout/footer.php'?>
