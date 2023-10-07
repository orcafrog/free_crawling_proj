<?php
  $same_password = 0;
  $same_user = 0;
  $username = $_POST[ 'username' ];
  $password = $_POST[ 'password' ];
  $password_confirm = $_POST[ 'password_confirm' ];
  if (!is_null( $username)){
    $db = mysqli_connect( 'localhost','root','**********', 'userlist' );
    $query = "SELECT username FROM member WHERE username = '$username';";
    $result = mysqli_query( $db, $query );
    //변수에 user이름 을 저장
    while ($row = mysqli_fetch_array($result)){
      $username_e = $row[ 'username' ];
    }
    //같은 유저가 있는지 검사
    if ( $username == $username_e ) {
      $same_user = 1;
    }
    //비밀번호가 같은지 검사
    elseif ( $password != $password_confirm ) {
      $same_password = 1;
    }
    //모든 조건을 통과하면 db에 저정하고 login 페이지로 이동하기
    else {
      $encrypted_password = password_hash( $password, PASSWORD_DEFAULT);
      $query = "INSERT INTO member ( username, password ) VALUES ( '$username', '$encrypted_password' );";
      mysqli_query( $db, $query );
      header( 'Location: ../pr_login/pr_login.html' );
    }
  }
  if ( $same_user == 1 ) {
    echo "<script>alert('사용자이름이 중복되었습니다.'); history.back(-2);</script>";
  }
  if ( $same_password == 1 ) {
    echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back(-2);</script>";
  }
  mysqli_close($db);
?>
