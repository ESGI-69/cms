<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "./vendor/PHPMailer-6.5.3/src/Exception.php";
require "./vendor/PHPMailer-6.5.3/src/PHPMailer.php";
require "./vendor/PHPMailer-6.5.3/src/SMTP.php";

class Mailer
{
  private $phpMailer;

  public function __construct()
  {
    $this->phpMailer = new PHPMailer();
    $this->phpMailer->IsSMTP();
    $this->phpMailer->Host = MAILHOST; // Adresse IP ou DNS du serveur SMTP
    $this->phpMailer->Port = MAILPORT; // Port TCP du serveur SMTP
    $this->phpMailer->SMTPAuth = TRUE; // Utiliser l'identification
    $this->phpMailer->CharSet = 'UTF-8';

    if($this->phpMailer->SMTPAuth) {
      $this->phpMailer->SMTPDebug  = 0;
      $this->phpMailer->SMTPSecure = 'tls'; // Protocole de sécurisation des échanges avec le SMTP
      $this->phpMailer->Username = MAILUSER; // Adresse email à utiliser
      $this->phpMailer->Password = MAILPWD; // Mot de passe de l'adresse email à utiliser
    }
    $this->phpMailer->From = trim(MAILUSER); //L'email à afficher pour l'envoi
    $this->phpMailer->FromName = trim(MAILALIAS);
  }

  public function sendVerifMail(string $mail, string $emailVerifyToken): bool {
    $this->phpMailer->AddAddress(trim($mail));
    $this->phpMailer->Subject = "Wikiki - Confirmez votre email"; // Le sujet du mail
    $this->phpMailer->WordWrap = 50; // Nombre de caracteres pour le retour a la ligne automatique

    // TODO Un partial de body pour les mails ?
    $this->phpMailer->Body = "Cliquez <a href='http://localhost/verify?t=".$emailVerifyToken."'>ici</a>"; // Body HTML
    $this->phpMailer->AltBody = "Cliquez ici : http://localhost/verify?t=".$emailVerifyToken; // Body brut
    $this->phpMailer->IsHTML(false); // Préciser qu'il faut utiliser le texte brut

    if (!$this->phpMailer->send()) {
      echo $this->phpMailer->ErrorInfo;
      return false;
    } else{
      echo 'Message bien envoyé';
      return true;
    }
  }
}
