<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
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
    // Si il n'y a pas d'erreur dans le form
    if(!empty($_POST)){

      $result = Verificator::checkForm($user->getRegisterForm(), $_POST);

      if (count($result) === 0) {
        $user->setRegisterInfo();
        $user->save();
        // TODO Send le mail de verif à l'utilisateur
      } else {
        print_r($result);
      }
    }
    $view = new View("register");
    $view->assign("user", $user);
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
