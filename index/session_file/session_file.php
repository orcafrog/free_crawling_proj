<?php
  session_start();
  $session_login = FALSE;
  $cookie_login = FALSE;
  if(isset( $_SESSION[ 'username' ])){
    $session_login = TRUE;
  }
  if(isset($_COOKIE['username'])){
    $cookie_login = TRUE;
  }
?>
