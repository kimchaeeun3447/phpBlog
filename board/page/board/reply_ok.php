<?php
	include $_SERVER['DOCUMENT_ROOT']."/board/db.php";

    $bno = $_GET['idx'];
    $userpw = password_hash($_POST['dat_pw'], PASSWORD_DEFAULT);
    //수빈-변수설정진행
    $dat_user=$_POST['dat_user'];
    $content=$_POST['content'];

    if($bno && $_POST['dat_user'] && $userpw && $_POST['content']){
        $sql = mq("insert into reply(con_num,name,pw,content) values('".$bno."','".$dat_user."','".$userpw."','".$content."')");
//('".$bno."','".$_POST['dat_user']."','".$userpw."','".$_POST['content']."')");
        echo "<script>
        alert('댓글 작성을 완료했습니다.'); 
        location.href='/board/page/board/read.php?idx=$bno';</script>";
    }else{
        echo "<script>alert('댓글 작성에 실패했습니다.'); 
        history.back();</script>";
    }
	
?> 
