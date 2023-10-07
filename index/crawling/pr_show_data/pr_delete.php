<?php
$username = $_COOKIE["username"];
$db = mysqli_connect( 'localhost','root','**********', 'userlist' );
$query = "DELETE from all_data where username = '$username';"; //유저의 정보를 모두 삭제 추가로 drop을 이용해서 아예 유저자체를 지울 수 있게 생각중
mysqli_query($db,$query);
echo "<script>alert('크롤링한 내용이 모두 삭제 되었습니다.');</script>";
echo "<script>location.href='../haha.html'</script>";
//header( 'Location: ../haha.html' );//header 로 설정되면 echo가 무시된 php에서 넘어갈건데 굳이 echo 출력할 필요없어 라고 처리해서 그럼
mysqli_close($db);
?>
