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
    $view = new View("Login", "back");

    $view->assign("pseudo", "Prof");
    $view->assign("firstname", "Yves");
    $view->assign("lastname", "Skrzypczyk");

  }

  public function register()
  {
    $user = new UserModel();
    $isMailSent = null;

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
