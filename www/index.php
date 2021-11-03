<?php

// split parameters and put them in an array
$params = explode('/', $_GET['p']);

// if 1 parameters exist 
if ($params[0] != "") {
  // save first parameter in $routeName
  $routeName = '/'.$params[0];
//else return  '/' in $routeName
} else {
  $routeName = '/';
}
