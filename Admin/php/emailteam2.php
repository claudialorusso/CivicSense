<?php
require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();

$id = $_POST['id'];
$team = $_POST['team'];


if ($id && $team !== null) {


    $query = ("SELECT email_t FROM team WHERE codice = ?");

    $statement = $conn->prepare($query);
    $statement->bind_param('s', $team);

    $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows === 0) exit ('Errore nel recupero dello ID ');

    if ($result) {
        echo('<a href="mailto: ' . htmlspecialchars($result, ENT_NOQUOTES) . '"><center> Clicca qui per mandare un avviso al team. </center></a>');

    }

}

DBconnection::CloseCon();
?>