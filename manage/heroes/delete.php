<?php

require '../layout/header.php';

use Service\Container;

$isDeleted = false;

if (isset($_POST['deleteHero'])) {
    $id = $_POST['deleteHero'];

    $container = new Container($configuration);
    $heroLoader = $container->getHeroLoader();
    $hero = $heroLoader->findOneById($id);
    if ($hero !== null) {
        $heroLoader->deleteHero($hero);
        $isDeleted = true;
    }
}

?>
<?php
    echo ($isDeleted) ? ('<h2>This hero has met a terrible end!</h2>')
    : ('<h2>Hero not found</h2>');
?>

<a href="/index.php">Return to the battle!</a>

<?php require '../layout/footer.php'?>
