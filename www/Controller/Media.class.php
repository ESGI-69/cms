<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Core\Logger;
use App\Core\AuthManager;

use App\Model\Media as MediaModel;

class Media extends Sql
{
  public function mediasList()
  {
    $log = new Logger();
    $media = new MediaModel();

    if (isset($_GET['deletedId'])) {
      $media->getMediaInfo($_GET['deletedId']);
      unlink($media->get($_GET['deletedId'])->path);
      $log->add("media", "Media '" . $media->getName() . "' deleted by user n." . $media->getUserId() . "!");
      $media->delete($_GET['deletedId']);
    }

    $this->medias = $media->getAll();

    $view = new View("mediasList", "back", "Medias");
    $view->assign("media", $media);
    $view->assign("medias", $this->medias);
  }

  public function mediaManager()
  {
    $log = new Logger();
    $media = new MediaModel();
    $saved = false;
    $formErrors = [];
    $registerError = false;
    if (!empty($_POST)) {
      $formErrors = Verificator::checkForm($media->getMediaForm(), $_POST);
      if (count($formErrors) === 0) {
        $media->setMediaInfo();
        $registerError = $media->checkExisting('name');
        if ($registerError === false) {
          $media->saveMedia();
          $saved = true;
          $log->add("media", "Media '" . $media->getName() . "' added by user n." . $media->getUserId() . "!");
          header("Location: /medias-list");
        } else {
          $formErrors[] = "Nom de média déjà utilisé";
        }
      }
    }

    $view = new View("mediaManager", "back", "New Media");
    $view->assign("media", $media);
    $view->assign("success", $saved);
    $view->assign("errors", $formErrors);
  }
}
