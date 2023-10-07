<?php
setCookie('username', '', time()-1000, '/'); //쿠키 파괴
session_start(); //세션 시작하고
session_destroy(); //세션 파괴
?>
<script>
    alert("안녕히 가세요");
    location.replace('../../../main.php');
</script>
