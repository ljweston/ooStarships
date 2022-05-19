<?php

require_once __DIR__.'/lib/Model/ship.php';
require_once __DIR__.'/lib/Model/rebelship.php';
require_once __DIR__.'/lib/Model/battleResult.php';
require_once __DIR__.'/lib/Service/battleManager.php';
require_once __DIR__.'/lib/Service/shipLoader.php';
require_once __DIR__.'/lib/Service/container.php';

// DB CONFIGURATION INFO
$configuration = [
    'db_dsn' =>'mysql:host=localhost;dbname=OOPShips',
    'db_user' => 'root',
    'db_pass' => '',
];