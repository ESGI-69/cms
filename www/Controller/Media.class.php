<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;

use App\Model\Media as MediaModel;

class Media extends Sql
{
  public function mediasList()
  {
    $media = new MediaModel();

    // if route param deleted is set, delete the media
    if (isset($_GET['deletedId'])) {
      $this->deleteMedia($_GET['deletedId']);
    }

    $this->medias = $this->getMedias();

    $view = new View("mediasList", "back", "Liste des médias");
    $view->assign("media", $media);
    $view->assign("medias", $this->medias);
  }

  public function mediaManager()
  {
    $media = new MediaModel();


    $view = new View("mediaManager", "back", "Editer - MEDIA NAME");
    $view->assign("media", $media);
  }
}