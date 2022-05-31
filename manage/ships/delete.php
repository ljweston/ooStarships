<?php

require '../layout/header.php';

use Service\Container;

// pass in id as a submitted value to pass to our query
if (isset($_POST['deleteShip'])) {
    $id = $_POST['deleteShip'];

    $container = new Container($configuration);
    $shipLoader = $container->getShipLoader();
    // may want to check that the id is valid. If not we usually get an error back, but do not want to interrupt the program.
    $shipLoader->deleteShip($id);
} else {
    echo '<h1> There is no ship to delete</h1>';
}
?>

<!-- Display a message to either re-route a user or to return to the battle menu -->
<h2>This ship has been sent to the scrap yard.</h2>

<a href="/index.php">Return to the battle!</a>

<?php require '../layout/footer.php'?>
