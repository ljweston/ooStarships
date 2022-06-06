<?php

require '../layout/header.php';

use Model\hero;
use Service\Container;
use Model\AbstractShip; // get the teams

$teams = AbstractShip::getTeams();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team = $_POST['team'];
    if (empty($team)) {
        $errors = 'All ships must have an allegiance';
    } elseif (!in_array($team, $teams)) {
        $errors[] = 'Select a valid team';
    }

    $name = $_POST['name'];
    if (empty($name)) {
        $errors[] = 'This hero needs a name';
    }

    $newHero = new Hero($name);

    $newHero->setTeam($team);
    
    $newHero->setJediFactor($_POST['jedi-factor']);
    if (empty($newHero->getJediFactor())) {
        $newHero->setJediFactor(0);
    } elseif (!is_numeric($newHero->getJediFactor())) {
        $errors[] = 'Jedi factor must be a number';
    }

    if (count($errors) == 0) {
        $container = new Container($configuration);
        $heroLoader = $container->getHeroLoader();
        $heroLoader->saveHero($newHero);

        header('Location: /manage/heroes/index.php');
        die;
    }

}

?>

<div class="container">
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/manage/heroes/index.php">Manageheroes</a></li>
        <li>Add hero</li>
    </ul>
    <div class="row">
        <div class="col-xs-6">
            <h1>Add a new hero</h1>
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
            <form action="/manage/heroes/new.php" method="POST">
                <div class="form-group">
                    <label for="hero-name">Hero Name</label>
                    <input type="text" name="name" id="hero-name">
                </div>
                <div class="form-group">
                    <label for="hero-jedi-factor">Jedi Factor</label>
                    <input type="text" name="jedi-factor" id="hero-jedi-factor">
                </div>
                <div class="form-group">
                    <label for="hero-team">hero Allegiance</label>
                    <select name="team" id="hero-team">
                        <option value="">-- Select One --</option>
                        <?php foreach ($teams as $team) : ?>
                            <option value="<?php echo $team?>">
                                <?php echo ucfirst($team)." Hero"?>
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
