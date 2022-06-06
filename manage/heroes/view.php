<?php
require '../layout/header.php';

use Service\Container;

$id = isset($_GET['id']) ? $_GET['id'] : null;

$container = new Container($configuration);
$heroLoader = $container->getHeroLoader();

$hero = $heroLoader->findOneById($id);

?>

<div class="container">
        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/manage/heroes/index.php">ManageHeroes</a></li>
            <li><?php echo $hero === null ? "hero not found" : $hero->getName()?></li>
        </ul>
        <?php if ($hero === null): ?>
            <h1> hero Not Found </h1>
        <?php else: ?>
            <div class="page-header">
                <h1>Viewing <?php echo $hero->getName()?></h1>
            </div>
            
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th style="width: 150px;">Name:</th>
                        <td><?php echo $hero->getName()?></td>
                    </tr>
                    <tr>
                        <th>Jedi Power:</th>
                        <td><?php echo $hero->getJediFactor()?></td>
                    </tr>
                    <tr>
                        <th>Allegiance:</th>
                        <td><?php echo ucfirst($hero->getTeam())?></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <a href="/manage/heroes/edit.php?id=<?php echo $id?>" class="btn btn-md btn-success">Edit</a>
                <form action="/manage/heroes/delete.php?id=<?php echo $id?>" method="POST">
                    <button class="btn btn-md btn-danger" name="deleteHero" value="<?php echo $id?>">Delete</button>
                </form>
                
            </div>
        <?php endif; ?>
    </div>
<?php require '../layout/footer.php'?>
