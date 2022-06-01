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
    $result = $statement->execute();
	
	if($result){
		//da ente a team
		$row = mysqli_fetch_assoc($result);
		if($row['stato']=="In attesa" && $stato=="In risoluzione"){ //confronta stato attuale e quello da modificare
			$sql = "UPDATE segnalazioni SET stato = '$stato' WHERE id = ?"; //esegui l'aggiornamento
            $statement = $conn->prepare($sql);
            $statement->bind_param('i', $idS);
            $result = $statement->execute();
			if($query){
				echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
				$mail = new PHPMailer(true);
	
				try {
				  $mail->SMTPAuth   = true;                  // sblocchi SMTP 
				  $mail->SMTPSecure = "ssl";                 // metti prefisso per il server
				  $mail->Host       = "smtp.gmail.com";      // metti il tuo domino es(gmail) 
				  $mail->Port       = 465;   				// inserisci la porta smtp per il server DOMINIO
				  $mail->SMTPKeepAlive = true;
				  $mail->Mailer = "smtp";
				  $mail->Username   = "civicsense18@gmail.com";     // DOMINIO username
				  $mail->Password   = "c1v1csense2019";            // DOMINIO password
				  $mail->AddAddress($_SESSION['email']);
				  $mail->SetFrom("civicsense18@gmail.com");
				  $mail->Subject = 'Nuova Segnalazione';
				  $mail->Body = "Salve team" . $row['team'] . ", ci è arrivata una nuova segnalazione e vi affido il compito di risoverla"; //Messaggio da inviare
				  $mail->Send();
				  echo "Message Sent OK";
				} catch (phpmailerException $e) {
					  echo $e->errorMessage(); //Errori da PHPMailer
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

            if($query){
				echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
				$mail = new PHPMailer(true);
	
				try {
				  $mail->SMTPAuth   = true;                  // sblocchi SMTP 
				  $mail->SMTPSecure = "ssl";                 // metti prefisso per il server
				  $mail->Host       = "smtp.gmail.com";      // metti il tuo domino es(gmail) 
				  $mail->Port       = 465;   				// inserisci la porta smtp per il server DOMINIO
				  $mail->SMTPKeepAlive = true;
				  $mail->Mailer = "smtp";
				  $mail->Username   = $_SESSION['email'];  			// DOMINIO username
				  $mail->Password   = $_SESSION['pass'];            // DOMINIO password
				  $mail->AddAddress('civicsense18@gmail.com');//ente
				  $mail->AddAddress($row['email']);//utente
				  $mail->SetFrom($_SESSION['email']);
				  $mail->Subject = "Segnalazione risolta";
				  $mail->Body = "Il problema presente in " . $row['via'] . " è stata risolta"; //Messaggio da inviare
				  $mail->Send();
				  echo "Message Sent OK";
				} catch (phpmailerException $e) {
					  echo $e->errorMessage(); //Errori da PHPMailer
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