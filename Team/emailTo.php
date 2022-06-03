<?php
// create sessions to know the user is logged in

require_once(dirname(__DIR__, 1) . '\session.php');
$session = new session();
// Set to true if using https
$session->start_session('_s', false);


//puoi modificare la pagina per farla funzionare nella tua macchina
//adatto a tutti i domini (GMAIL,LIBERO.HOTMAIL)
//classi per l'invio dell'email (PHPMailer 5.2)

require_once (dirname (__DIR__,1).'\db_connection.php');
$conn = DBconnection::OpenCon();

if (isset($_POST['id']) && isset($_POST['stato'])) {
    $idS = $_POST['id'];
    $stato = $_POST['stato'];
    $email = $_SESSION['email'];
    $pass = $_SESSION['pass'];

    $query = "SELECT * FROM segnalazioni WHERE id = ?";

    $statement = $conn->prepare($query);
    $statement->bind_param('i', $idS);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows === 0) exit ('Inserire un ID valido');
    while ($row = $result->fetch_assoc()) {
        if (!$result) {
            echo 'Inserire un ID valido!';
        } else {
            //da team a ente e utente
            $row = $result->fetch_assoc();
            if ($row['stato'] == "In attesa" && $stato == "In risoluzione") { //confronta stato attuale e quello da modificare
                $sql = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?"; //esegui l'aggiornamento

                $statement = $conn->prepare($sql);
                $statement->bind_param('i', $idS);
                $statement->execute();
                $result1 = $statement->get_result();
                if ($result1->num_rows === 0) exit ('Errore nel recupero dello ID ');
                while ($row = $result1->fetch_assoc()) {
                    if ($result1) {
                        echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                        $subject = 'Nuova Segnalazione';
                        $body = "La segnalazione è arrivata ed stiamo lavorando per risolverla"; //Messaggio da inviare
                        $recipients = ["civicsense2019@gmail.com", $row['email']];
                        $mail = new Mail($subject, $body, $recipients, true);

                        try {
                            $mail->Send();
                            echo "Message Sent OK";
                            header("location: http://localhost/CivicSense/Team/index.php");
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }
                }
            } //da team a ente e utente
            else if ($row['stato'] == "In risoluzione" && $stato == "Risolto") {
                $sql = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?"; //esegui l'aggiornamento
                $statement = $conn->prepare($sql);
                $statement->bind_param('i', $idS);
                $statement->execute();
                if ($result1->num_rows === 0) exit ('Errore nel recupero dello ID ');
                while ($row = $result1->fetch_assoc()) {
                    if ($result1) {
                        echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                        $subject = 'Segnalazione risolta';
                        $body = "Il problema presente in " . $row['via'] . " è stata risolta"; //Messaggio da inviare
                        $recipients = ["civicsense2019@gmail.com", $row['email']];
                        $mail = new Mail($subject, $body, $recipients, true);
                        try {
                        $mail->Send();
                            header("location: http://localhost/CivicSense/Team/index.php");
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    } else {
                    echo "Operazione non disponibile";
                    }
                }
            }
        }
    }
}

DBconnection::CloseCon();

?>