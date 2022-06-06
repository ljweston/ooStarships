<?php

require '../layout/header.php';

use Service\Container;

$error = false;

if (isset($_POST['deleteHero'])) {
    $id = $_POST['deleteHero'];

    $container = new Container($configuration);
    $heroLoader = $container->getHeroLoader();
    $hero = $heroLoader->findOneById($id);
    if ($hero !== null) {
        $heroLoader->deleteHero($hero);
    } else {
        echo '<h1> There is no hero with this ID to delete </h1>';
        $error = true;
    }
} else {
    echo '<h2> There is no ship to delete</h2>';
}

?>
<?php
    echo (!$error) ? ('<h2>This hero has met a terrible end!</h2>')
    : ('');
?>

<a href="/index.php">Return to the battle!</a>

<?php require '../layout/footer.php'?>
