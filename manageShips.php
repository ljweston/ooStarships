<?php
require __DIR__.'/bootstrap.php';
// Page to manage and display a ship table and link to view ships alone
// for Edit/ Delete or Add ships

use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();
?>

<html>
    <head>
        <meta charset="utf-8">
           <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <title>Manage Ships</title>

           <!-- Bootstrap -->
           <link href="css/bootstrap.min.css" rel="stylesheet">
           <link href="css/style.css" rel="stylesheet">
           <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

           <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
           <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
           <!--[if lt IE 9]>
             <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
             <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
           <![endif]-->
    </head>

    <!-- Error handling -->

    <body>
        <div class="container">
            <div class="page-header">
                <h1>Manage Our Ships</h1>
            </div>
            <table class="table table-hover">
                <caption><i class="fa fa-rocket"></i> View/ Edit These Ships</caption>
                <a href="index.php" class="btn btn-md btn-primary pull-right">Return Home</a>
                <thead>
                    <tr>
                        <th>Ship</th>
                        <th>Weapon Power</th>
                        <th>Jedi Factor</th>
                        <th>Strength</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ships as $ship): ?>
                        <tr>
                            <td><a href=""><?php echo $ship->getName(); ?></a></td>
                            <td><?php echo $ship->getWeaponPower(); ?></td>
                            <td><?php echo $ship->getJediFactor(); ?></td>
                            <td><?php echo $ship->getStrength(); ?></td>
                            <td><?php echo $ship->getType(); ?></td>
                            <td>
                                <?php if ($ship->isFunctional()) : ?>
                                    <i class="Fa fa-sun-o"></i>
                                <?php else : ?>
                                    <i class="fa fa-cloud"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>