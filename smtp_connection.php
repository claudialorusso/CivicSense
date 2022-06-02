<?php

//TODO vd 25 emailTo, vd 69 emailTo, vd 35 emailteam
class SMTPConnection {
    private static $mail;

    function __construct(){
        $this->mail = new PHPMailer(true);
    }

    function OpenConn($team){
    self::setUpCredentials($team);
    self::$mail->Send();
    self::CloseConn();
    }

    private static function setUpCredentials ($team) {
        try {
            require_once realpath(__DIR__ . '/vendor/autoload.php');
            Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->safeLoad();

            self::$mail->SMTPAuth   = true;                  // sblocchi SMTP
            self::$mail->SMTPSecure = "ssl";                 // metti prefisso per il server
            self::$mail->Host       = $_ENV["SMTP_HOST"];      // metti il tuo domino es(gmail)
            self::$mail->Port       = $_ENV["SMTP_PORT"];    				// inserisci la porta smtp per il server DOMINIO
            self::$mail->SMTPKeepAlive = true;
            self::$mail->Mailer = $_ENV["SMTP_MAILER"];
            self::$mail->Username   = $_ENV["SMTP_USERNAME"];      // DOMINIO username
            self::$mail->Password   = $_ENV["SMTP_PASSWORD"]; ;    // DOMINIO password
            self::$mail->AddAddress($_SESSION['email']);
            self::$mail->SetFrom($_ENV["SMTP_USERNAME"]);
            self::$mail->Subject = 'Nuova Segnalazione';
            self::$mail->Body = "Salve team" . $team . ", ci è arrivata una nuova segnalazione e vi affido il compito di risoverla"; //Messaggio da inviare

        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Errori da PHPMailer
        } catch (Exception $e) {
            echo $e->getMessage(); //Errori da altrove
        }
    }
    public static function CloseConn()
    {
        self::$email->smtpClose();
    }

}
