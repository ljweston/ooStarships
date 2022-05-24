<?php

require __DIR__.'/vendor/autoload.php';

// Autoloaders
// spl_autoload_register(function($className) {
//     // using two backslashes reoresents one backslash because it is an escape character
//     $path = __DIR__.'/lib/'.str_replace('\\', '/', $className).'.php';

//     if (file_exists($path)) {
//         require $path;
//     }
// });

// DB CONFIGURATION INFO
$configuration = [
    'db_dsn' =>'mysql:host=localhost;dbname=OOPShips',
    'db_user' => 'root',
    'db_pass' => '',
];
