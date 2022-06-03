<?php
// create sessions to know the user is logged in

require_once(dirname(__DIR__, 1) . '\session.php');
$session = new session();
// Set to true if using https
$session->start_session('_s', false);
//puoi modificare la pagina per farla funzionare nella tua macchina
//adatto a tutti i domini (GMAIL,LIBERO.HOTMAIL)
//classi per l'invio dell'email (PHPMailer 5.2)

require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();

if (isset($_POST['id'])&& isset($_POST['stato'])) {
	$idS = $_POST['id'];
	$stato = $_POST['stato'];
	
	$query = "SELECT * FROM segnalazioni WHERE id =?";

    $statement = $conn->prepare($query);
    $statement->bind_param('i', $idS);

	if($statement->execute()){
		//da ente a team
        $result = $statement->get_result();
        $row = mysqli_fetch_assoc($result);
		if($row['stato']=="In attesa" && $stato=="In risoluzione"){ //confronta stato attuale e quello da modificare
			$sql = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?"; //esegui l'aggiornamento
            $statement = $conn->prepare($sql);
            $statement->bind_param('i', $idS);
            $result = $statement->execute();
			if($result){
				echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                $subject = 'Nuova Segnalazione';
                $body =  "Salve team" . $row['team'] . ", ci è arrivata una nuova segnalazione e vi affido il compito di risoverla"; //Messaggio da inviare
                $recipients = [$_SESSION['email']];
                $mail = new Mail($subject, $body, $recipients, true, "civicsense18@gmail.com");
	
				try {
                    $mail->Send();
				    echo "Message Sent OK";
				} catch (Exception $e) {
					  echo $e->getMessage(); //Errori da altrove
				}
			} 
		}
		//da team a ente e utente
		else if($row['stato']=="In risoluzione" && $stato=="Risolto"){
			$sql = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?";

            $statement = $conn->prepare($sql);
            $statement->bind_param('i', $idS);
            $result = $statement->execute();

            if($result){
                $subject =  "Segnalazione risolta";
                $body = "Il problema presente in " . $row['via'] . " è stata risolta"; //Messaggio da inviare
                $recipients = [$row['email'],'civicsense18@gmail.com'];
                $mail = new Mail($subject, $body, $recipients, true, "civicsense18@gmail.com");

                echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
	
				try {
				  $mail->Send();
				  echo "Message Sent OK";
				} catch (Exception $e) {
					  echo $e->getMessage(); //Errori da altrove
				}
			} 
		}
		else{
			echo "Operazione non disponibile";
		}
	}
}
DBconnection::CloseCon();

?>