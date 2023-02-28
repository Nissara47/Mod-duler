<?php

    require __DIR__.'\..\Firebase\vendor\autoload.php';
    
    use Kreait\Firebase\Factory;

    $factory = (new Factory)
        ->withServiceAccount('mod-duler-firebase-adminsdk-aq4mc-454825770f.json')
        ->withDatabaseUri('https://mod-duler-default-rtdb.asia-southeast1.firebasedatabase.app/');

    $database = $factory->createDatabase();

?>