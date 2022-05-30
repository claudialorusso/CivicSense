<?php

    //TODO questo file si può cancellare a questo punto (Francesco)
    require_once realpath(__DIR__ . '/vendor/autoload.php');
    Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    // MySQL Database credentials

    if (!defined('USER')) define('USER', $_ENV['DB_USER']);
    if (!defined('PASSWORD')) define('PASSWORD', $_ENV['DB_PASSWORD']);
    if (!defined('HOST')) define('HOST', $_ENV['DB_HOST']);
    if (!defined('DATABASE')) define('DATABASE',$_ENV['DB_NAME']);



     try {
        $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE,USER,PASSWORD);
        return $connection;
     } catch (PDOException $e){
        exit("Error:" . $e->getMessage());
    }

?>