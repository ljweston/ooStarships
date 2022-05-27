<?php 
// Display already entered data and allow uses to edit it. Doing similar checks to new

require '../layout/header.php';

use Model\AbstractShip;
use Service\Container;

$teams = AbstractShip::getTeams();
$errors = [];
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
                    <input type="text" name="name" id="ship-name" value="<?php echo ''?>">
                </div>
                <div class="form-group">
                    <label for="ship-weapon-power">Weapon Power</label>
                    <input type="text" name="weapon-power" id="ship-weapon-power" value="<?php echo ''?>">
                </div>
                <div class="form-group">
                    <label for="ship-jedi-factor">Jedi Factor</label>
                    <input type="text" name="jedi-factor" id="ship-jedi-factor" value="<?php echo ''?>">
                </div>
                <div class="form-group">
                    <label for="ship-strength">Strength</label>
                    <input type="text" name="strength" id="ship-strength" value="<?php echo ''?>">
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

                <button btn btn-primary><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>
<?php require '../layout/footer.php'?>
