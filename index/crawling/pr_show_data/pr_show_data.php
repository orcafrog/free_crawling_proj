<?php
  require $_SERVER['DOCUMENT_ROOT'].'/index/session_file/session_file.php';//로그인 되었는지 검사
  //session_start();
  if($session_login == FALSE){
    header('Location: /main.php');
  }

  if($cookie_login != TRUE){
    header('Location: /main.php');
  }

?>

<?php

  $username = $_COOKIE["username"];
  $db = mysqli_connect( 'localhost','root','**********', 'userlist' );

?>

<h1>크롤링 데이터 확인하기</h1>
<?php

$query = "SELECT * from all_data where username = '$username' ";
$result = mysqli_query($db, $query);

?>
    <table border = 1>
      <tr><th>NO</th> <th>사용자 이름</th> <th>크롤링 내용</th> <th>작성일</th></tr>
<?php
  $id = 1;
  while($row = mysqli_fetch_assoc($result)){
    echo "<tr>
          <td> {$id}</td>
          <td> {$row['username']} </td>
          <td> {$row['crawling_data']}</td>
          <td> {$row['insert_time']} </td>
          </tr>";
    $id++;
  }

mysqli_close($db);
?>
</table>
<html>
<head>
  <br>
  <button type="button" onclick="location.href='pr_delete.php'">데이터 리셋 하기</button>
  <button type="button" onclick="location.href='../haha.html'">restart</button>
  <button type="button" onclick="location.href='../pr_show_data/pr_now_show_data.php'">최근 크롤링한 내용 확인</button>
  <button type="button" onclick="location.href='../../check_user/pr_logout/pr_logout.php'">LOGOUT</button>
</head>
</html>
