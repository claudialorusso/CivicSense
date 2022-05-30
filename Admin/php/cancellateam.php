<?php

require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();

//$conn = mysqli_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('db_name')) or die ("Connessione non riuscita");

$cod = (isset($_POST['cod'])) ? $_POST['cod'] : null;

if (isset($_POST['submit2'])) {

    if ($cod == null) {
        echo("<p> <center> <font color=black font face='Courier'> Compila tutti i campi.</center></p>");
    } elseif ($cod !== null) {

        $sql = "SELECT * FROM team WHERE codice =?";


        $statement = $conn->prepare($sql);
        $statement->bind_param('s', $cod);
        $resultC = $statement->execute();

        #$resultC = mysqli_query($conn, "SELECT * FROM team WHERE codice =' $cod'");
        if ($resultC) {
            $row = mysqli_fetch_assoc($resultC);
            if ($cod == $row['codice']) {
                $query = "DELETE FROM team WHERE codice = ?";

                $statement = $conn->prepare($query);
                $statement->bind_param('s', $cod);
                $result = $statement->execute();

                #$result = mysqli_query($conn,$query);

                if ($query) {
                    echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                }
            } else {
                echo("<p> <center> <font color=black font face='Courier'> Inserisci ID esistente.</center></p>");
            }
        }
    }
}
DBconnection::CloseCon();

?>