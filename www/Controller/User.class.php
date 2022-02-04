<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Core\Mailer;
use App\Model\User as UserModel;

class User {

  public function login()
  {
    $user = new UserModel();

    if(!empty($_POST)){
      $result = Verificator::checkForm($user->getLoginForm(), $_POST);
      if (count($result) === 0) {
        $user->setLoginInfo();
        $queryResult = $user->login($user->getEmail());
        if (empty($queryResult)) {
          echo "Mail incorrect";
        }
        else {
          if ($queryResult['status'] === "0") {
            echo "confirmez votre mail";
          }
          else if ($queryResult['status'] === "1") {
            if(password_verify($_POST['password'], $queryResult['password'])){
              echo " mdp valide";
            }
            else {
              echo "mdp invalide";
            }
          }
          else if ($queryResult['status'] === "2"){
            echo "vous etes banni";
          }
        }
        //TODO Message d'erreur dans la view
        /*
        echo"<pre>";
        print_r($user);
        echo"</pre></br>";

        echo"<pre>";
        print_r($queryResult);
        echo"</pre>";
        */
      }
      else {
        print_r($result);
      }
    }

    $view = new View("Login");
    $view->assign("user", $user);
  }

  public function register()
  {
    $user = new UserModel();
    $isMailSent = null;

    //TODO ne pas send le mail si ce n'est pas enregistrer en BDD
    if(!empty($_POST)){
      $result = Verificator::checkForm($user->getRegisterForm(), $_POST);
      // Si il n'y a pas d'erreur dans le form
      if (count($result) === 0) {
        $user->setRegisterInfo();
        $user->save();
        $mailer = new Mailer();
        $isMailSent = $mailer->sendVerifMail($user->getEmail(), $user->getEmailToken());
      } else {
        print_r($result);
      }
    }
    $view = new View("register");
    $view->assign("user", $user);
    $view->assign("isMailSent", $isMailSent);
  }

  public function logout()
  {
    echo "Se déco";
  }

  public function pwdforget()
  {
    echo "Mot de passe oublié";
  }

}
