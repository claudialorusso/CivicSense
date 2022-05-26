<?php
    // MySQL Database credentials

    if (!defined('USER')) define('USER', 'root');
    if (!defined('PASSWORD')) define('PASSWORD', '');
    if (!defined('HOST')) define('HOST', 'localhost');
    if (!defined('DATABASE')) define('DATABASE','civicsense');



     try {
        $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE,USER,PASSWORD);
        return $connection;
     } catch (PDOException $e){
        exit("Error:" . $e->getMessage());
    }

?>



/*
* PRIMA:
$conn = mysqli_connect(HOST, USER, PASSWORD) or die ("Connessione non riuscita"); #connessione a mysql, la pass non la ho xk è scaricato automaticamente

mysqli_select_db($conn, DATABASE) or die ("DataBase non trovato"); #connessione al db
*
*/