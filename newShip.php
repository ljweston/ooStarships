<?php
require __DIR__.'/bootstrap.php';

require 'bootstrap.php';
// file to create, validate, and save to the database.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // validate data

    // depending on type of ship we create either a rebel ship or empire ship
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

            <form action="/newShip.php" method="POST">
                <div>
                    <label for="ship-name">Ship Name</label>
                    <input type="text" name="name" id="ship-name">
                </div>
                <div>
                    <label for="ship-weapon-power">Weapon Power</label>
                    <input type="text" name="weapon-power" id="ship-weapon-power">
                </div>
                <div>
                    <label for="ship-jedi-factor">Jedi Factor</label>
                    <input type="text" name="jedi-factor" id="ship-jedi-factor">
                </div>
                <div>
                    <label for="ship-strength">Strength</label>
                    <input type="text" name="strength" id="ship-strength">
                </div>
                <div>
                    <label for="ship-types">Ship Type</label>
                    <select name="types" id="ship-types">
                        <option value="rebel">Rebel Ship</option>
                        <option value="empire">Empire Ship</option>
                    </select>
                </div>

                <button btn btn-primary><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>
