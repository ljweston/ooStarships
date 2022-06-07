<?php 
// Display already entered data and allow uses to edit it. Doing similar checks to new

require '../layout/header.php';

use Model\AbstractShip;
use Service\Container;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$teams = AbstractShip::getTeams();
$errors = [];

// get our heroes
$container = new Container($configuration);
$heroLoader = $container->getHeroLoader();
$heroes = $heroLoader->getHeroes();

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

    $ship->setName($_POST['name']);
    if (empty($ship->getName())) {
        $errors[] = 'This ship needs a name';
    }
    
    $ship->setWeaponPower($_POST['weapon-power']);
    if (empty($ship->getWeaponPower())){
        $ship->setWeaponPower(0);
    } elseif (!is_numeric($ship->getWeaponPower())) {
        $errors[] = 'Weapon power must be a number';
    }

    // numeric vals
    $ship->setJediFactor($_POST['jedi-factor']);
    if (empty($ship->getJediFactor())) {
        $ship->setJediFactor(0);
    } elseif (!is_numeric($ship->getJediFactor())){
        $errors[] = 'Jedi factor must be a number';
    }

    // future feature of ship health
    $ship->setMaxHealth($_POST['health']);
    if (empty($ship->getMaxHealth())) {
        $ship->setMaxHealth(0);
    } elseif (!is_numeric($ship->getMaxHealth())) {
        $errors[] = 'Max Health must be a number';
    }

    // add logic for ships assigning a new hero. Check that the hero is the same team as the ship
    $hero = $heroLoader->findOneById($_POST['hero_id']);

    if($hero !== null) {
        if ($hero->getTeam() == $ship->getType()) {
            $ship->setHero($hero);
        } else {
            $errors[] = 'Your hero can only fight for ships of type: '.$ship->getType();
        }
    }

    if (count($errors) == 0) {
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
                    <label for="ship-health">Max Health</label>
                    <input type="text" name="health" id="ship-health" value="<?php echo $ship->getMaxHealth()?>">
                </div>
                <div class="form-group">
                    <label for="ship-team">Ship Allegiance</label>
                    <select name="team" id="ship-team" disabled>
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
                <div class="form-group">
                    <label for="heroSelection"></label>
                    <select class="form-control btn drp-dwn-width btn-default dropdown-toggle" name="hero_id" id="heroSelection">
                        <option value="<?php echo $ship->getHero()->getId();?>"><?php echo $ship->getHero();?></option>
                        <?php foreach ($heroes as $hero): ?>
                            <?php if ($hero->getTeam() == $ship->getType()) { ?>
                                <option value="<?php echo $hero->getId(); ?>"><?php echo $hero->getNameAndPower(); ?></option>
                            <?php }?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn btn-success" name="shipId" value="<?php echo $id?>"><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>
<?php require '../layout/footer.php'?>
