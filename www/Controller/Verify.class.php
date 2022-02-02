<?php

  namespace App\Controller;

  use App\Core\View;
  use App\Core\Sql;

  class Verify extends Sql
  {
    protected $isEmailVerified;

    public function verify()
    {
      $this->isEmailVerified = $this->verifyEmail($_GET['t']);
      $view = new View('verify');
      $view->assign('isEmailVerified', $this->isEmailVerified);
    }
  }