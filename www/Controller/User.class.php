<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Core\Mailer;
use App\Model\User as UserModel;

class User
{

  public function login()
  {
    $user = new UserModel();
    $login = false;
    $userInfos = null;

    $formErrors = [];

    if (!empty($_POST)) {
      $formErrors = Verificator::checkForm($user->getLoginForm(), $_POST);
      if (count($formErrors) === 0) {
        $user->setLoginInfo();
        $queryResult = $user->login($user->getEmail());
        if (empty($queryResult)) {
          $formErrors[] = "Email ou mot de passe invalide";
        } else {
          if ($queryResult['status'] === "0") {
            $formErrors[] = "Confirmez votre mail";
          } else if ($queryResult['status'] === "1") {
            if (password_verify($_POST['password'], $queryResult['password'])) {
              $login = true;
              $userInfos = array(
                "firstname" => $queryResult["firstname"],
              );

              setcookie('wikikiToken', $queryResult['token'], time() + 60 * 60 * 24 * 30);
            } else {
              $formErrors[] = "Email ou mot de passe invalide";
            }
          } else if ($queryResult['status'] === "2") {
            $formErrors[] = "Vous etes banni";
          }
        }
      }
    }

    $view = new View("Login", "front", "Connexion");
    $view->assign("user", $user);
    $view->assign("success", $login);
    $view->assign("errors", empty($formErrors) ? null : $formErrors);
    $view->assign("userInfos", $userInfos);
  }

  public function register()
  {
    $user = new UserModel();
    $isMailSent = null;
    $registered = false;
    $registerError = false;

    $formErrors = [];

    if (!empty($_POST)) {
      $formErrors = Verificator::checkForm($user->getRegisterForm(), $_POST);
      // Si il n'y a pas d'erreur dans le form
      if (count($formErrors) === 0) {
        $user->setRegisterInfo();
        $registerError = $user->checkExistingMail();
        // check si l'email n'est pas déjà utilisé
        if (!$registerError) {
          $user->save();
          $mailer = new Mailer();
          $isMailSent = $mailer->sendVerifMail($user->getEmail(), $user->getEmailToken());
          $registered = true;
        } else {
          $formErrors[] = "Email déjà utilisé";
        }
      }
    }
    $view = new View("register", 'front', 'Inscription');
    $view->assign("user", $user);
    $view->assign("success", $registered);
    $view->assign("errors", $formErrors);
    $view->assign("isMailSent", $isMailSent);
  }

  // Remove the wikikiToken cookie and redirect to the home page
  public function logout()
  {
    $success = false;
    if (isset($_COOKIE['wikikiToken'])) {
      setcookie('wikikiToken', null, -1);
      $success = true;
    }
    $view = new View("logout");
    $view->assign("success", $success);
  }

  public function pwdforget()
  {
    echo "Mot de passe oublié";
  }
}
