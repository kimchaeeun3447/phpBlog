<!-- delete.php
게시물 상세보기에서 삭제버튼을 누르면 삭제한다.
-->

<?php
	include $_SERVER['DOCUMENT_ROOT']."/board/db.php";
	
	$bno = $_GET['idx'];
    
    //채은 수정
	$sql = mq("delete from board where idx='$bno';");
?>

<script type="text/javascript">alert("삭제되었습니다.");</script>

<!--삭제 후 게시물 목록 페이지 index.php로 이동한다-->
<meta http-equiv="refresh" content="0 url=../../index.php" />