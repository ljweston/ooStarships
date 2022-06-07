<?php
require '../layout/header.php';

use Service\Container;

$container = new Container($configuration);

$heroLoader = $container->getHeroLoader();
$heroes = $heroLoader->getHeroes();

?>

    <div class="container">
        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li>ManageHeroes</li>
        </ul>
        <div class="page-header">
            <h1>Manage Our Ships</h1>
        </div>
        <table class="table table-hover">
            <caption><i class="fa fa-rocket"></i> View/ Edit These Heroes</caption>
            <a href="/" class="btn btn-md btn-primary pull-right">Return Home</a>
            <thead>
                <tr>
                    <th>Hero</th>
                    <th>Jedi Factor</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($heroes as $hero): ?>
                    <tr>
                        <td>
                            <a href="/manage/heroes/view.php?id=<?php echo $hero->getId();?>">
                                <?php echo $hero->getName(); ?>
                            </a>
                        </td>
                        <td><?php echo $hero->getJediFactor(); ?></td>
                        <td><?php echo $hero->getTeam(); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div>
            <a href="/manage/heroes/new.php" class="btn btn-success">Add New Hero</a>
        </div>
    </div>

    <?php require '../layout/footer.php';
