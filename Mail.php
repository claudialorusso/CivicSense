<?php

use PHPMailer\PHPMailer\PHPMailer;
require_once realpath(__DIR__ . '/vendor/autoload.php');


class Mail extends PHPMailer
{
    public function __construct($subject, $body, $recipients, $exceptions=true, $from="")
    {
        parent::__construct($exceptions);
        require_once realpath(__DIR__ . '/vendor/autoload.php');
        Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad();

        $this->SMTPAuth   = true;                  // sblocchi SMTP
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;// metti prefisso per il server
        $this->Host       = $_ENV["SMTP_HOST"];    // metti il tuo domino es(gmail)
        $this->Port       = $_ENV["SMTP_PORT"];    // inserisci la porta smtp per il server DOMINIO
        $this->SMTPKeepAlive = true;
        $this->Mailer = $_ENV["SMTP_MAILER"];
        $this->Username   = $_ENV["SMTP_USERNAME"];  // DOMINIO username
        $this->Password   = $_ENV["SMTP_PASSWORD"];  // DOMINIO password
        foreach ($recipients as $address) {
            $this->AddAddress($address);
        }
        $from = $from === "" ? $_ENV["SMTP_USERNAME"] : $from;
        $this->SetFrom($from);
        $this->Subject = $subject;
        $this->Body = $body;
    }

    public function send()
    {
        $sent = parent::send();
        $this->smtpClose();
        return $sent;
    }
}