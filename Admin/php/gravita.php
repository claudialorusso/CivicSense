<?php
require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();

$id = (isset($_POST['id'])) ? $_POST['id'] : null;
$stato = (isset($_POST['stato'])) ? $_POST['stato'] : null;

if (isset($_POST['submit'])) {

    if ($id && $stato !== null) {


        $query = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?"; //esegui l'aggiornamento


        $statement = $conn->prepare($query);
        $statement->bind_param('i', $id);

        $result1 = $statement->execute();
        $result = mysqli_query($conn, $query);

        if ($result) {

            while ($row = mysqli_fetch_assoc($result)) {

                if ($id == $row['id']) {

                    echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                } else {

                    echo("INSERISCI UN ID ESISTENTE");
                }

            }
        }
    } else {
        echo("inserisci tutti i campi");
    }
}

DBconnection::CloseCon();
?>