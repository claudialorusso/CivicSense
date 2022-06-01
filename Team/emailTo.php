<?php
// create sessions to know the user is logged in

require_once(dirname(__DIR__, 1) . '\session.php');
$session = new session();
// Set to true if using https
$session->start_session('_s', false);


//puoi modificare la pagina per farla funzionare nella tua macchina
//adatto a tutti i domini (GMAIL,LIBERO.HOTMAIL)
//classi per l'invio dell'email (PHPMailer 5.2)


require('phpmailer/class.phpmailer.php');
include('phpmailer/class.smtp.php');
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
    $result = $statement->execute();

    if ($result) {
        //da team a ente e utente
        $row = $result->fetch_assoc();
        if ($row['stato'] == "In attesa" && $stato == "In risoluzione") { //confronta stato attuale e quello da modificare
            $sql = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?"; //esegui l'aggiornamento

            $statement = $conn->prepare($sql);
            $statement->bind_param('i', $idS);
            $result1 = $statement->execute();


            if ($result1) {
                echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPAuth = true;                  // sblocchi SMTP
                    $mail->SMTPSecure = "ssl";                 // metti prefisso per il server
                    $mail->Host = "smtp.gmail.com";      // metti il tuo domino es(gmail)
                    $mail->Port = 465;                // inserisci la porta smtp per il server DOMINIO
                    $mail->SMTPKeepAlive = true;
                    $mail->Mailer = "smtp";
                    $mail->Username = "$email";        // DOMINIO username
                    $mail->Password = "$pass";        // DOMINIO password
                    $mail->AddAddress("civicsense2019@gmail.com");
                    $mail->AddAddress($row['email']);
                    $mail->SetFrom("$email");
                    $mail->Subject = 'Nuova Segnalazione';
                    $mail->Body = "La segnalazione è arrivata ed stiamo lavorando per risolverla"; //Messaggio da inviare
                    $mail->Send();
                    echo "Message Sent OK";
                    header("location: http://localhost/Ingegneria/Team/index.php");
                } catch (phpmailerException $e) {
                    echo $e->errorMessage(); //Errori da PHPMailer
                } catch (Exception $e) {
                    echo $e->getMessage(); //Errori da altrove
                }
            }
        } //da team a ente e utente
        else if ($row['stato'] == "In risoluzione" && $stato == "Risolto") {
            $sql = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?"; //esegui l'aggiornamento
            $statement = $conn->prepare(sql);
            $statement->bind_param('i', $idS);
            $result1 = $statement->execute();
            #$result1 = $conn->query($sql);
            if ($result1) {
                echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPAuth = true;                  // sblocchi SMTP
                    $mail->SMTPSecure = "ssl";                 // metti prefisso per il server
                    $mail->Host = "smtp.gmail.com";      // metti il tuo domino es(gmail)
                    $mail->Port = 465;                // inserisci la porta smtp per il server DOMINIO
                    $mail->SMTPKeepAlive = true;
                    $mail->Mailer = "smtp";
                    $mail->Username = "$email";        // DOMINIO username
                    $mail->Password = "$pass";        // DOMINIO password
                    $mail->AddAddress("civicsense2019@gmail.com");
                    $mail->AddAddress($row['email']);
                    $mail->SetFrom("$email");
                    $mail->Subject = "Segnalazione risolta";
                    $mail->Body = "Il problema presente in " . $row['via'] . " è stata risolta"; //Messaggio da inviare
                    $mail->Send();
                    header("location: http://localhost/Ingegneria/Team/index.php");
                } catch (phpmailerException $e) {
                    echo $e->errorMessage(); //Errori da PHPMailer
                } catch (Exception $e) {
                    echo $e->getMessage(); //Errori da altrove
                }


            }
        } else {
            echo "Operazione non disponibile";
        }
    }
}

DBconnection::CloseCon();

?>