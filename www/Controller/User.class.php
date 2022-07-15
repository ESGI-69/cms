<?php

namespace App\Controller;

use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Core\Mailer;
use App\Core\Logger;
use App\Core\AuthManager;
use App\Model\User as UserModel;
use App\Model\PasswordReset as PasswordResetModel;

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
      Header("Location: /");
    }
    $view = new View("logout");
    $view->assign("success", $success);
  }

  public function pwdforget()
  {
    $user = new UserModel();
    $success = false;
    $log = Logger::getInstance();
    $email = null;
    $passwordReset = new PasswordResetModel();

    $formErrors = [];

    if (!empty($_POST)) {
      $formErrors = Verificator::checkForm($user->getPasswordForgetForm(), $_POST);
      if (count($formErrors) === 0) {
        $email = $_POST['email'];
        $passwordReset->setEmail($email);
        $user->setEmail($email);
        if ($passwordReset->checkExisting('email') === false && $user->checkExisting('email') !== false) {
          $mailer = new Mailer();
          $passwordReset->setChangeKey(substr(bin2hex(random_bytes(128)), 0, 128));
          $passwordReset->setExpDate(date('Y-m-d H:i:s', strtotime('+1 day')));
          $passwordReset->setUserId($user->checkExisting('email'));
          $id = $passwordReset->save();
          $passwordReset->setId($id);
          $success = $mailer->sendResetMail($email, ["id" => $passwordReset->getId(), "changeKey" => $passwordReset->getChangeKey()]);
          if (!$success) {
            $formErrors[] = "Erreur lors de l'envoi du mail. Contactez un admin.";
          } else {
            $log->add("user", "User '" . $user->getFirstname() . "' with email '" . $user->getEmail() . "' asked for a new password");
          }
        } else {
          if ($passwordReset->checkExisting('email') !== false) {
            $formErrors[] = "Un mail de réinitialisation de mot de passe a déjà été envoyé";
          }
          if ($user->checkExisting('email') === false) {
            $formErrors[] = "Email inconnu";
          }
        }
      }
    }

    $view = new View("passwordForget", 'front', 'Mot de passe oublié');
    $view->assign("user", $user);
    $view->assign("success", $success);
    $view->assign("errors", $formErrors);
    $view->assign("email", $email);
  }

  public function pwdReset()
  {
    $log = Logger::getInstance();
    $user = new UserModel();
    $passwordReset = new PasswordResetModel();
    $success = false;
    $formErrors = [];

    if ($_GET['id'] && $_GET['changeKey']) {
      $info = $passwordReset->getPasswordResetInfo($_GET['id']);
      if (!empty($info) && $passwordReset->getChangeKey() === $_GET['changeKey']) {
        if (strtotime($passwordReset->getExpDate()) > strtotime(date('Y-m-d H:i:s'))) {
          $user->getUserInfos($passwordReset->getUserId());
          // Si le user a rempli le form pour changer son mot de passe
          if (!empty($_POST)) {
            $formErrors = Verificator::checkForm($user->getPasswordResetForm(), $_POST);
            if (count($formErrors) === 0) {
              $user->setPassword($_POST['password']);
              $user->save();
              $success = true;
              $log->add("user", "User '" . $user->getFirstname() . "' with email '" . $user->getEmail() . "' reset his password");
              $passwordReset->delete($_GET['id']);
            }
          }
        } else {
          $formErrors[] = "Ce lien de réinitialisation de mot de passe a expiré";
        }
      } else {
        $formErrors[] = "Ce lien de réinitialisation de mot de passe n'est pas valide";
      }
    } else {
      $formErrors[] = "Ce lien de réinitialisation de mot de passe n'est pas valide";
    }

    $view = new View("passwordReset", 'front', 'Réinitialisation du mot de passe');
    $view->assign("user", $user);
    $view->assign("success", $success);
    $view->assign("errors", $formErrors);
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
    $log = Logger::getInstance();


    if (isset($_GET['deletedId'])) {
      $user->delete($_GET['deletedId']);
      $log->add("user", "User with id '" . $_GET['deletedId'] . "' deleted");
    }

    $this->users = $user->getAll();

    $view = new View("usersList", "back", "Users");
    $view->assign("user", $user);
    $view->assign("users", $this->users);
  }

  public function me()
  {
    $user = new UserModel();
    $auth = new AuthManager();
    $formErrors = [];
    $registerError = false;
    $isMailSent = null;
    $registered = false;
    $log = Logger::getInstance();

    if ($auth->isAuth() === true) {
      $userInfos = $auth->userInfos();
      $user->getUserInfosAdmin($userInfos['id']);

      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($user->getUserFormFront(), $_POST);
        if (count($formErrors) === 0) {
          $user->setUserInfosAdmin();
          $registerError = $user->checkExisting('email') !== false;
          if ($registerError === false) {
            if ($user->mailedChanged()) {
              $mailer = new Mailer();
              $isMailSent = $mailer->sendVerifMail($user->getEmail(), $user->getEmailToken());
            }
            $user->edit();
            header("Location: /me");
            $registered = true;
            $log->add("user", "User '" . $user->getFirstname() . "' with email '" . $user->getEmail() . "' edited");
          } else {
            $formErrors[] = "Email déjà utilisé";
          }
        }
      }
    }

    $view = new View("me", "front", "Profil");
    $view->assign("user", $user);
    $view->assign("success", $registered);
    $view->assign("errors", $formErrors);
    $view->assign("registerError", $registerError);
    $view->assign("isMailSent", $isMailSent);
    // $view->assign("isAuth", $auth->isAuth());
  }


  public function userManager()
  {
    $user = new UserModel();
    $log = Logger::getInstance();
    $formErrors = [];
    $registerError = false;
    $isMailSent = null;
    $registered = false;

    if (isset($_GET['id'])) {
      $user->getUserInfosAdmin($_GET['id']);
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($user->getUserForm(), $_POST);
        if (count($formErrors) === 0) {
          $user->setUserInfosAdmin();
          $registerError = $user->checkExisting('email') !== false;
          if ($registerError === false) {
            if ($user->mailedChanged()) {
              $mailer = new Mailer();
              $isMailSent = $mailer->sendVerifMail($user->getEmail(), $user->getEmailToken());
            }
            $user->edit();
            $registered = true;
            $log->add("user", "User with id '" . $_GET['id'] . "' edited");
            header("Location: /users-list");
          } else {
            $formErrors[] = "Email déjà utilisé";
          }
        }
      }
    } else {
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($user->getUserForm(), $_POST);
        // Si il n'y a pas d'erreur dans le form
        if (count($formErrors) === 0) {
          $user->setUserInfosAdmin();
          $registerError = $user->checkExisting('email') !== false;
          // check si l'email n'est pas déjà utilisé
          if (!$registerError) {
            $user->save();
            $mailer = new Mailer();
            $isMailSent = $mailer->sendVerifMail($user->getEmail(), $user->getEmailToken());
            $registered = true;
            $log->add("user", "User '" . $user->getFirstname() . "' with email '" . $user->getEmail() . "' added");
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
