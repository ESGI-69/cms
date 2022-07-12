<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Core\Mailer;
use App\Core\Logger;
use App\Model\User as UserModel;

class User extends Sql
{

  public function loginUser()
  {
    $user = new UserModel();
    $login = false;
    $userInfos = null;

    $formErrors = [];

    $log = Logger::getInstance();

    if (!empty($_POST)) {
      $formErrors = Verificator::checkForm($user->getLoginForm(), $_POST);
      if (count($formErrors) === 0) {
        $user->setLoginInfo();
        $queryResult = $user->login($user->getEmail());
        if (empty($queryResult)) {
          $formErrors[] = "Email ou mot de passe invalide";
        } else {
          if ($queryResult->status === "0") {
            $formErrors[] = "Confirmez votre mail";
          } else if ($queryResult->status === "1") {
            if (password_verify($_POST['password'], $queryResult->password)) {
              $login = true;
              $userInfos = array(
                "firstname" => $queryResult->firstname,
                "email" => $queryResult->email,
              );

              $log->add("user", "User '" . $queryResult->firstname . "' with email '" . $queryResult->email . "' logged in");

              setcookie('wikikiToken', $queryResult->token, time() + 60 * 60 * 24 * 30);
            } else {
              $formErrors[] = "Email ou mot de passe invalide";
            }
          } else if ($queryResult->status === "2") {
            $formErrors[] = "🫵 Vous etes banni 🫵";
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
    $log = Logger::getInstance();

    $formErrors = [];

    if (!empty($_POST)) {
      $formErrors = Verificator::checkForm($user->getRegisterForm(), $_POST);
      // Si il n'y a pas d'erreur dans le form
      if (count($formErrors) === 0) {
        $user->setRegisterInfo();
        $registerError = $user->checkExisting('email');
        // check si l'email n'est pas déjà utilisé
        if (!$registerError) {
          $user->save();
          $mailer = new Mailer();
          $isMailSent = $mailer->sendVerifMail($user->getEmail(), $user->getEmailToken());
          $registered = true;
          $log->add("user", "User '" . $user->getFirstname() . "' with email '" . $user->getEmail() . "' registered");
        } else {
          $formErrors[] = "Email déjà utilisé";
        }
      }
    }
    $view = new View("register", 'front', 'Inscription');
    $view->assign("user", $user);
    $view->assign("success", $registered);
    $view->assign("errors", $formErrors);
    $view->assign("registerError", $registerError);
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

  public function verify()
  {

    $this->isEmailVerified = $this->verifyEmail($_GET['t']);
    $view = new View('verify');
    $view->assign('isEmailVerified', $this->isEmailVerified);
  }

  public function usersList()
  {
    $user = new UserModel();

    if (isset($_GET['deletedId'])) {
      $user->delete($_GET['deletedId']);
    }

    $this->users = $user->getAll();

    $view = new View("usersList", "back", "Users");
    $view->assign("user", $user);
    $view->assign("users", $this->users);

  }

  public function userManager()
  {
    $user = new UserModel();
    $formErrors = [];
    $registerError = false;
    $isMailSent = null;
    $registered = false;

    // à faire
    if (isset($_GET['id'])) {
      $user->getUserInfos($_GET['id']);
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($user->getUserForm(), $_POST);
        if (count($formErrors) === 0) {
          $user->setUserInfo();
          if ($registerError === false) {
            $user->edit();
            $saved = true;
            header("Location: /users-list");
          } else {
            $formErrors[] = "Nom de user déjà utilisé";
          }
        }
      }
    } else {
      echo"blo";
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($user->getUserForm(), $_POST);
        // Si il n'y a pas d'erreur dans le form
        if (count($formErrors) === 0) {
          $user->setUserInfo();
          $registerError = $user->checkExisting('email');
          // check si l'email n'est pas déjà utilisé
          if (!$registerError) {
            $user->save();
            $mailer = new Mailer();
            $isMailSent = $mailer->sendVerifMail($user->getEmail(), $user->getEmailToken());
            $registered = true;
            header("Location: /users-list");
          } else {
            $formErrors[] = "Email déjà utilisé";
          }
        }
      }
    }


    $view = new View("userManager", "back", "New user");
    $view->assign("user", $user);
    $view->assign("success", $registered);
    $view->assign("errors", $formErrors);
    $view->assign("registerError", $registerError);
    $view->assign("isMailSent", $isMailSent);
  }

}
