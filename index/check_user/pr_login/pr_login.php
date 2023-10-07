<?php
  require $_SERVER['DOCUMENT_ROOT'].'/index/session_file/session_file.php'; //로그인 체크
  //session_start();
  if($session_login != TRUE){
    echo "<script>alert('로그인 실패');</script>"; // 로그인 실패 == 세션 생성x 라는 아이디어에서 생각한 코드
    echo "<script>location.href='../../../main.php'</script>";
    //header('Location: ../../../main.php');
  }
?>
<?php
  $user_password = 1;
  $done = 0;
  $username = $_POST[ 'username' ];
  $password = $_POST[ 'password' ];
  if (!is_null( $username )){
    $db = mysqli_connect( 'localhost','root','**********', 'userlist' );//비밀번호 비공개
    $query = "SELECT password FROM member WHERE username = '" . $username . "';";
    $result = mysqli_query( $db, $query );
    //패스워드(해시된) 가져오기
    while ( $row = mysqli_fetch_array($result)){
      $encrypted_password = $row[ 'password' ];
    }

    if (is_null($encrypted_password)){//비어있다면 로그인 실패를 위해 user_password를 0으로 바꿈
      $user_password = 0;
    }

    else {
      if (password_verify($password, $encrypted_password)){//패스워드와 복호화한 패스워드가 같으면 done = 1로 바꿈
        $done = 1;
      }
    }
  }

?>

<?php
if($done == 1){//done = 1이면 세션 쿠키 생성
  $_SESSION["username"] = "$username";
  setcookie("username", "$username", time() + 3600, "/");
  echo $_SESSION["username"];
  if($done == 1){
    header( 'Location: ../../pr_check.php' );
  }
}
mysqli_close($db);
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <button type="button" onClick="location.href='pr_login.html'">go to login</button>
  </body>
</html>
