<?php

require '../layout/header.php';

use Model\Hero;
use Service\Container;

$container = new Container($configuration);
$heroLoader = $container->getHeroLoader();

$errors = [];

// POST REQ handling w/ error handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['heroId'])) {
        $id = $_POST['heroId'];
        $hero = $heroLoader->findOneById($id); // get a hero obj
        if ($hero == null) {
            echo 'HERO NOT FOUND';
            die;
        }
    } else {
        throw new \Exception('NO HERO WITH THIS ID FOUND');
    }

    $hero->setName($_POST['name']);
    if (empty($hero->getName())) {
        $errors[] = 'This hero needs a name';
    }

    $hero->setJediFactor($_POST['jedi-factor']);
    if (empty($hero->getJediFactor())) {
        $hero->setJediFactor(0);
    } elseif (!is_numeric($hero->getJediFactor())) {
        $errors[] = 'Jedi Factor must be a number';
    }

    if (count($errors) == 0) {
        $heroLoader->updateHero($hero);
        // not used in E3
        header('Location: /manage/heroes/index.php');
        die;
    }
}
// GET REQ handling
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $hero = $heroLoader->findOneById($id);
    if ($hero === null) {
        echo '<h2> Hero not found </h2>';
        die;
    }
}

?>

<div class="container">
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/manage/heroes/index.php">Manageheroes</a></li>
        <li><a href="/manage/heroes/view.php?id=<?php echo $id;?>"><?php echo $hero->getName();?></a></li>
        <li><?php echo $hero === null ? "Hero not found" : 'Editing '.$hero->getName()?></li> 
    </ul>
    <div class="row">
        <div class="col-xs-6">
            <h1>Edit This hero</h1>
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
            <form action="/manage/heroes/edit.php" method="POST">
                <div class="form-group">
                    <label for="hero-name">Hero Name</label>
                    <input type="text" name="name" id="hero-name" value="<?php echo $hero->getName()?>">
                </div>
                <div class="form-group">
                    <label for="hero-jedi-factor">Jedi Factor</label>
                    <input type="text" name="jedi-factor" id="hero-jedi-factor" value="<?php echo $hero->getJediFactor()?>">
                </div>
                <div class="form-group">
                    <label for="hero-team">Hero Allegiance</label>
                    <select name="team" id="hero-team" disabled>
                        <!-- loaded original/ saved value first -->
                        <option value="<?php echo $hero->getTeam()?>">
                        <?php echo ucfirst($hero->getTeam())." Hero"?>
                    </select>
                </div>

                <button class="btn btn-success" name="heroId" value="<?php echo $id?>"><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>
<?php require '../layout/footer.php'?>
