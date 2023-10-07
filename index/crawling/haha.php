<?php
  require $_SERVER['DOCUMENT_ROOT'].'/index/session_file/session_file.php';//사이트에 세션과 쿠기가 있는지 검증하는 파일
  //session_start();
  if($session_login == FALSE){//없다면 메인으로 이동
    header('Location: /main.php');
  }

  if($cookie_login != TRUE){//없다면 메인으로 이동
    header('Location: /main.php');
  }

?>

<?php
  $url_name = $_POST['url_name'];
  $first_tag = $_POST['first_tag'];

  $db = mysqli_connect( 'localhost','root','**********', 'userlist' );
  /*
  if(!isset($_SESSION)){
    header("Location: ../main.php");
  }
  */

  header("Content-Type:text/html;charset=utf-8");//인코딩 부분
  ini_set("allow_url_fopen",1);//크롤링 error 수정 부분
  require_once('lib/simple_html_dom.php');// simple_html_dom.php 찾아서 가져오기
  $change_txt = [];//텍스트를 리스트에 담을때 사용할 변수
  $i = 1;//리스트 위치 지정을 위해 사용한 변수값
  $data = file_get_html("$url_name");//크롤링할 사이트를 입력 받는창 변수 $url_name에서 받아온 사이트 링크 넣을 예정

    foreach($data->find("$first_tag") as $tag){ //크롤링한 사이트에서 ul테그 중 list_txt에 해당하는 부분 찾는 부분 이부분에 first_tag를 넣어서 이용할 예정
      $change_txt[$i] = $tag->plaintext;//속성 없에고 문자로 바꾸는 코드
      //echo $change_txt[$i];//바꾼 li 태그속 값들을 리스트에 하나씩 저장
      //echo "<br>";//값 확인을 위한 코드 후에 지울예정
      $i++;//리스트 위치 변경
    }

  //오류 검증 변수에 아무것도 담기지 않았을때
  if(isset($change_txt)){
    echo "success";
  }
  else{
    echo "<script>alert('크롤링에 실패했습니다')</script>";
    echo "<script>location.href='./pr_show_data/pr_now_show_data.php'</script>";
  }
  //크롤링 코드
  $crawling_data = implode($change_txt);//크롤링한 데이터를 하나의 데이터로 바꾸는 코드
  $crawling_data = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", '', $crawling_data);//정규식을 이용해 특수문자 제거
  $username = $_COOKIE["username"]; //쿠키가 불러오기

  $query = "SELECT * from all_data where username = '$username' ";//쿠키 값을 이용해 유저 찾기
  $result = mysqli_query($db, $query);

  $query = "INSERT INTO all_data (username,crawling_data) VALUES('{$username}','{$crawling_data}');"; //크롤링 데이터 저장
  mysqli_query($db,$query);
  mysqli_close($db);

  $db = mysqli_connect( 'localhost','root','**********', 'userlist' ); //위에 처럼 디비를 닫았다 다시 연결해줘야 처음 들어온 데이터도 업데이트가 잘됨
  $query = "SELECT * from all_data where username = '$username' ";
  $result = mysqli_query($db, $query);

  while($row = mysqli_fetch_array($result)){
    if(strlen($row['crawling_data']) == 0){
      $query= "UPDATE all_data SET crawling_data = 'unknown' where username = '$username' and crawling_data='';";
      mysqli_query($db,$query);
    }
  }
  mysqli_close($db);
?>
<html>
<head>
  <br>
  <button type="button" onclick="location.href='../index/check_user/pr_logout/pr_logout.php'">LOGOUT</button>
  <button type="button" onclick="location.href='haha.html'">restart</button>
  <button type="button" onclick="location.href='./pr_show_data/pr_show_data.php'">show_all_data</button>
  <button type="button" onclick="location.href='./pr_show_data/pr_now_show_data.php'">show_now_data</button>
</head>
</html>
