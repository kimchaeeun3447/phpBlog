<!--write_ok.php
write.php에서 작성한 글을 db에 저장한다.
-->

<?php
include $_SERVER['DOCUMENT_ROOT']."/board/db.php";  //htdocs를 기준으로한 위치

//각 변수에 write.php에서 input name값들을 저장한다
$username = $_POST['name'];
$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);  // password를 암호화하기 위한 함수
$title = $_POST['title'];
$content = $_POST['content'];
$date = date('Y-m-d H:i:s'); //글을 등록한 날짜,시간 저장
//수빈 수정 파트 , true, false등으로 잠금 유무 조건문
if(isset($_POST['lockpost'])){
    $lo_post='1';
} else {
    $lo_post='0';
}

if($username && $userpw && $title && $content){
    //채은 수정 --> lock post 수빈 수정
    $sql = mq("insert into board(name,pw,title,content,date,lock_post) values('".$username."','".$userpw."','".$title."','".$content."','".$date."','".$lo_post."')");
    
    echo "<script>
    alert('글쓰기 완료되었습니다.');

    location.href='/board/index.php';</script>"; 

}else{
    echo "<script>
    alert('글쓰기에 실패했습니다.');
    history.back();</script>";
}
?>