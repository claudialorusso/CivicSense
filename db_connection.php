<?php

class DBconnection{
    private static $dbHost;
    private static $dbUsername;
    private static $dbPassword;
    private static $dbName;

    private static $setup = false;

    private static $conn= null;

    /*
    OpenCon():
        Apre una connessione al database e restituisce l'oggetto di classe PDO; Se è già aperta una connessione, restituisce la connessione già aperta.
    */
    public static function OpenCon()
    {
        if (! self::$setup) {
            self::setUpCredentials();
        }
        // One connection through whole application
        if (self::$conn == null)
        {
            try {
                self::$conn = mysqli_connect(self::$dbHost, self::$dbUsername, self::$dbPassword, self::$dbName) or die ("Connessione non riuscita");

            } catch(Exception $e)
            {
                error_log(print_r("Errore: $e", TRUE));
                die();
            }
        }
        return self::$conn;
    }

    public static function CloseCon()
    {
        self::$conn->close();
        self::$conn = null;
    }

    private static function setUpCredentials () {
        require_once realpath(__DIR__ . '/vendor/autoload.php');
        Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad();
        self::$dbHost = $_ENV["DB_HOST"];
        self::$dbUsername = $_ENV["DB_USER"];
        self::$dbPassword = $_ENV["DB_PASSWORD"];
        self::$dbName = $_ENV["DB_NAME"];
        self::$setup = true;
    }

}
