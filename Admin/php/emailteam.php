<?php
require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();

$id = (isset($_POST['id'])) ? $_POST['id'] : null;
$team = (isset($_POST['team'])) ? $_POST['team'] : null;


if (isset($_POST['submit'])) {

    if ($id && $team !== null) {

        $resultC = mysqli_query($conn, "SELECT * FROM segnalazioni WHERE gravita IS NOT NULL AND team IS NULL");
        if ($resultC) {
            $row = mysqli_fetch_assoc($resultC);
            if ($id == $row['id']) {
                $query = ("UPDATE segnalazioni SET team = '$team', stato = 'In attesa' WHERE id = ? ");

                $statement = $conn->prepare($query);
                $statement->bind_param('i', $id);
                $result = $statement->execute();

                if ($result) {

                    echo('<center><b>Aggiornamento avvenuto con successo.</b></center>');
                    $mail = new PHPMailer();

                    try {
                        $query1 = ("SELECT * FROM team WHERE codice = ?");
                        $statement = $conn->prepare($query1);
                        $statement->bind_param('s', $team);
                        $statement->execute();
                        #$result1 = mysqli_query($conn,$query1);
                        $result1 = $statement->get_result();
                        if ($result1->num_rows === 0) exit ('Errore nel recupero dello ID ');
                        while ($row = $result1->fetch_assoc()) {
                            if ($result1) {
                                $row = mysqli_fetch_assoc($result1);
                                $subject = 'Nuova Segnalazione';
                                $body = "Salve team $team, vi e' stata incaricata una nuova segnalazione da risolvere."; //Messaggio da inviare
                                $recipients = [$row["email_t"]];
                                $fromAddress = "civicsense2019@gmail.com";
                                $mail = new Mail($subject, $body, $recipients, true, $fromAddress);

                                $mail->Body = $mail->Send();
                                echo "<center><b>Messaggio inviato.</b></center>";
                            }
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage(); //Errori da altrove
                    }
                }
            } else {
                echo "<center><b>Inserisci un id esistente. </b></center>";
            }
        }


    } else {
        echo "<center><b>Inserire tutti i campi.</b></center>";
    }
}

DBconnection::CloseCon();
?>