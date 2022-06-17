<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Core\AuthManager;

use App\Model\Media as MediaModel;

class Media extends Sql
{
  public function mediasList()
  {
    $media = new MediaModel();

    if (isset($_GET['deletedId'])) {
      $media->delete($_GET['deletedId']);
    }

    $this->medias = $media->getAll();

    $view = new View("mediasList", "back", "Liste des médias");
    $view->assign("media", $media);
    $view->assign("medias", $this->medias);
  }

  public function mediaManager()
  {
    $media = new MediaModel();
    $saved = false;
    $formErrors = [];
    
    // à faire
    if (isset($_GET['id'])) {
      // $this->editMedia($_GET['editId']);
    } else {
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($media->getMediaForm(), $_POST);
        if (count($formErrors) === 0) {
          $media->setMediaInfo();
          $media->saveMedia();
        }
      }
    }

    $view = new View("mediaManager", "back", "Editer - MEDIA NAME");
    $view->assign("media", $media);
    $view->assign("success", $saved);
    $view->assign("errors", $formErrors);
  }

}