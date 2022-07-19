<?php 
if ($isAuth === true) {
  $this->includePartial("form", $user->getUserFormFront());
} else {
  die('404 Not found<br><img src="https://http.cat/404" alt="cat 404 http error" />');
}
