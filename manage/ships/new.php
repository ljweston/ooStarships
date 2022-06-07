<?php
require '../layout/header.php';

// file to create, validate, and save to the database.

use Model\RebelShip;
use Model\Ship;
use Model\AbstractShip;
use Service\Container;

$teams = AbstractShip::getTeams();
$errors = [];

// get our heroes
$container = new Container($configuration);
$heroLoader = $container->getHeroLoader();
$heroes = $heroLoader->getHeroes();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // confirm a team has been selected
    $team = $_POST['team'];
    if (empty($team)) {
        $errors[] = 'All ships must have an allegiance';
    } elseif (!in_array($team, $teams)) {
        $errors[] = 'Select a valid team';
    }
    // make sure a name has been created
    $name = $_POST['name'];
    if (empty($name)) {
        $errors[] = 'This ship needs a name';
    }
    // determine instance of ship to create
    if ($team == 'rebel') {
        $newShip = new RebelShip($name);
    } else {
        $newShip = new Ship($name);
    }
    // numeric vals
    $newShip->setWeaponPower($_POST['weapon-power']);
    if (empty($newShip->getWeaponPower())) {
        $newShip->setWeaponPower(0);
    } elseif (!is_numeric($newShip->getWeaponPower())) {
        $errors[] = 'Weapon power must be a number';
    }
    // numeric vals
    $newShip->setJediFactor($_POST['jedi-factor']);
    if (empty($newShip->getJediFactor())) {
        $newShip->setJediFactor(0);
    } elseif (!is_numeric($newShip->getJediFactor())){
        $errors[] = 'Jedi factor must be a number';
    }
    // change to be full health/ MAXHealth
    // check for empty and numeric values
    $newShip->setMaxHealth($_POST['health']);
    if (empty($newShip->getMaxHealth())) {
        $newShip->setMaxHealth(0);
    } elseif (!is_numeric($newShip->getMaxHealth())) {
        $errors[] = 'Max Health must be a number';
    }
    $newShip->setCurrentHealth($newShip->getMaxHealth());

    // assign a hero
    $hero = $heroLoader->findOneById($_POST['hero_id']);
    // Add logic for heroes not being assigned to an incorrect team
    if ($hero !== null) {
        if ($hero->getTeam() == $newShip->getType()) {
            $newShip->setHero($hero);
        } else {
            $errors[] = 'Your hero can only fight for ships of type: '.$newShip->getType();
        }
    }

    if (count($errors) == 0) {
        $container = new Container($configuration);
        $shipLoader = $container->getShipLoader();
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
                    <label for="ship-health">Max Health</label>
                    <input type="text" name="health" id="ship-health">
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
                <div class="form-group">
                    <label for="heroSelection"></label>
                    <select class="form-control btn drp-dwn-width btn-default dropdown-toggle" name="hero_id" id="heroSelection">
                        <option value="">Choose a Hero</option>
                        <?php foreach ($heroes as $hero): ?>
                            <option value="<?php echo $hero->getId(); ?>"><?php echo $hero->getNameAndPower(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>
<?php require '../layout/footer.php'?>
