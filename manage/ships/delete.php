<?php

require '../layout/header.php';

use Service\Container;

// pass in id as a submitted value to pass to our query
$error = false;

if (isset($_POST['deleteShip'])) {
    $id = $_POST['deleteShip'];

    $container = new Container($configuration);
    $shipLoader = $container->getShipLoader();
    $ship = $shipLoader->findOneById($id);
    if ($ship !== null) {
        $shipLoader->deleteShip($ship);
    } else {
        echo '<h1> There is no ship with this ID to delete</h1>';
        $error = true;
    }
    
} else {
    echo '<h2> There is no ship to delete</h2>';
}
?>

<!-- Display a message to either re-route a user or to return to the battle menu -->
<?php 
    echo (!$error) ? ('<h2>This ship has been sent to the scrap yard.</h2>') 
    : ('');
?>

<a href="/index.php">Return to the battle!</a>

<?php require '../layout/footer.php'?>
