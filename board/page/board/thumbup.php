<!--thumbup.php
게시물 상세보기에서 추천버튼을 누르면 증가시키고, db에 적용시킨다.
-->
<?php
	include $_SERVER['DOCUMENT_ROOT']."/board/db.php";
   
	$bno = $_GET['idx'];
    $thumbup = mysqli_fetch_array(mq("select thumbup from board where idx='$bno';"));
    $thumbup = $thumbup['thumbup'] + 1;
    mq("update board set thumbup=".$thumbup." where idx=".$bno.";");
?>

<script type="text/javascript">alert("추천되었습니다.");</script>

<!--채은 수정-->
<!--추천 후에도 상세보기 페이지에 머무른다. read.php-->
<meta http-equiv="refresh" content="0 url=read.php?idx=<?php echo $bno; ?>">