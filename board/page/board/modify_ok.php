<!--modify_ok.php
    수정한 글의 내용은 db에 적용시킨다.
-->

<?php
include $_SERVER['DOCUMENT_ROOT']."/board/db.php";

$bno = $_GET['idx']; //주소로 넘긴 idx 받기
$username = $_POST['name']; 
$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
$title = $_POST['title'];
$content = $_POST['content'];
$sql = mq("update board set name='".$username."',pw='".$userpw."',title='".$title."',content='".$content."' where idx='".$bno."'"); 
?>

<script type="text/javascript">alert("수정되었습니다."); </script>

<!--채은 수정-->
<!--다시 상세보기 페이지 read.php로 돌아간다-->
<meta http-equiv="refresh" content="0 url=read.php?idx=<?php echo $bno; ?>">