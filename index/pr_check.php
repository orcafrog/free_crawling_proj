<?php
require $_SERVER['DOCUMENT_ROOT'].'/index/session_file/session_file.php';

if($session_login){
  if($cookie_login){
    header( 'Location: ../index/crawling/haha.html' );
  }
  else{
    header( 'Location: ../index/check_user/pr_login/pr_login.html' );
  }
}
else{
  header( '../index/check_user/pr_login/pr_login.html' );
}
?>
