<?php

namespace App\Model;

use App\Core\Sql;

class Page extends Sql

{
  protected $id = null;
  protected $title = null;
  protected $url = null;
  protected $content = null;
  protected $subtile = null;
  protected $user_id = null;
  protected $category_id = null;
  
}
