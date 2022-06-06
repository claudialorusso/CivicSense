<?php
// create sessions to know the user is logged in
require_once(dirname(__DIR__, 1) . '\Mail.php');
require_once(dirname(__DIR__, 1) . '\session.php');
$session = new session();
// Set to true if using https
$session->start_session('_s', false);
//puoi modificare la pagina per farla funzionare nella tua macchina
//adatto a tutti i domini (GMAIL,LIBERO.HOTMAIL)
//classi per l'invio dell'email (PHPMailer 5.2)

require_once(dirname(__DIR__, 1) . '\db_connection.php');
$conn = DBconnection::OpenCon();

if (isset($_POST['id']) && isset($_POST['stato'])) {
    $idS = $_POST['id'];

    $stato = $_POST['stato'];

    $email = $_SESSION['email'];
    $pass = $_SESSION['pass'];

    $query = "SELECT * FROM segnalazioni WHERE id =?";

    $statement = $conn->prepare($query);
    $statement->bind_param('i', $idS);

    $res_ex = $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows === 0) exit ('Errore nel recupero dello ID ');
    while ($row = $result->fetch_assoc()) {
        if ($res_ex) {
            //da team a ente e utente

            if ($row && $row['stato'] == "In attesa" && $stato == "In risoluzione") { //confronta stato attuale e quello da modificare
                $sql1 = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?"; //esegui l'aggiornamento


                $statement1 = $conn->prepare($sql1);
                $statement1->bind_param('i', $idS);

                $res_ex = $statement1->execute();
                $result1 = $statement1->get_result();

                if ($res_ex) {
                    echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");


                    try {
                        $subject = 'Nuova Segnalazione';
                        $body = "La segnalazione è arrivata ed stiamo lavorando per risolverla"; //Messaggio da inviare
                        $recipients = ["civicsense2019@gmail.com", $row['email']];
                        echo "Message Sent OK";
                        $mail = new Mail($subject, $body, $recipients, true);
                        header("location: http://localhost/CivicSense/Team/index.php");
                    } catch (Exception $e) {
                        echo $e->getMessage(); //Errori da altrove
                    }
                }


            } else if ($row && $row['stato'] == "In risoluzione" && $stato == "Risolto") {//da team a ente e utente
                $sql1 = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?"; //esegui l'aggiornamento

                $statement1 = $conn->prepare($sql1);

                $statement1->bind_param('i', $idS);

                $res_ex = $statement1->execute();
                if ($res_ex) {
                    echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                    try {
                        $subject = "Segnalazione risolta";
                        $body = "Il problema presente in " . $row['via'] . " è stata risolta"; //Messaggio da inviare
                        $recipients = ["civicsense2019@gmail.com", $row['email']];
                        echo "Message Sent OK";
                        $mail = new Mail($subject, $body, $recipients, true);
                        header("location: http://localhost/CivicSense/Team/index.php");
                    } catch (Exception $e) {
                        echo $e->getMessage(); //Errori da altrove
                    }
                }

            } else {
                echo "Operazione non disponibile";
            }
        }
    }
}

DBconnection::CloseCon();

?>