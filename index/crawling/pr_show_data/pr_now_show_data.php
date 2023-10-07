<?php
  require $_SERVER['DOCUMENT_ROOT'].'/index/session_file/session_file.php';//로그인 체크
  //session_start();
  if($session_login == FALSE){
    header('Location: /main.php');
  }

  if($cookie_login != TRUE){
    header('Location: /main.php');
  }

?>

<?php
  $crawling_check = FALSE;
  $username = $_COOKIE["username"];
  $db = mysqli_connect( 'localhost','root','**********', 'userlist' );

  $get_time_query = "SELECT * from all_data where username = '$username' order by insert_time desc limit 1;";//시간을 이용해서 가장 최근값을 찾아오는 쿼리
  $time_result = mysqli_query($db,$get_time_query);

?>
<h1>지금 크롤링한 데이터 확인하기</h1>
<table border = 1>
<tr><th>NO</th> <th>사용자 이름</th> <th>크롤링 내용</th> <th>작성일</th></tr>

<?php
while($row = mysqli_fetch_array($time_result)){

  if(isset($row['crawling_data'])){
    $crawling_check = TRUE;
    echo "<tr>
          <td> 1 </td>
          <td> {$row['username']} </td>
          <td> {$row['crawling_data']}</td>
          <td> {$row['insert_time']} </td>
          </tr>";
    //break;
  }

}
?>
</tabel>

<?php
  if(!$crawling_check){
    echo "최근 크롤링한 데이터가 없습니다.<br>";
  }
  mysqli_close($db);
?>
<button type="button" onclick="location.href='../haha.html'">restart</button>
<button type="button" onclick="location.href='../pr_show_data/pr_show_data.php'">show_all_data</button>
<button type="button" onclick="location.href='../../check_user/pr_logout/pr_logout.php'">LOGOUT</button>
