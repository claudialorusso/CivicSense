<?php
require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();

$id = (isset($_POST['id'])) ? $_POST['id'] : null;
$stato = (isset($_POST['stato'])) ? $_POST['stato'] : null;


if ($id && $stato !== null) {

    $query = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?"; //esegui l'aggiornamento


    $statement = $conn->prepare($query);
    $statement->bind_param('i', $id);

    $result = $statement->execute();
    //$result = mysqli_query($conn, $query); //FIXME Claudia I think not necessary

    if ($result) {
        echo("<br><b><br><p> <center> <font color=black font face='Courier'> Inserimento avvenuto correttamente! Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
    }
}

DBconnection::CloseCon();

?>
	