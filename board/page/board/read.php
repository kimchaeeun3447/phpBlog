<!--read.php
게시물 클릭 시 상세보기 페이지이다.
-->
<?php
	include $_SERVER['DOCUMENT_ROOT']."/board/db.php";
?>

<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" type="text/css" href="../../style.css" />
<link rel="stylesheet" type="text/css" href="/BBS/css/jquery-ui.css" />
<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<!--<script type="text/javascript" src="/js/common.js"></script>-->
</head>


<body>
	<?php
		$bno = $_GET['idx']; //해당 글의 아이디 값
		
        $hit = mysqli_fetch_array(mq("select * from board where idx ='".$bno."'")); //아이디로 글 select
		
        //클릭 시 조회수 1증가 db에 업데이트
        $hit = $hit['hit'] + 1;   
        $fet = mq("update board set hit = '".$hit."' where idx = '".$bno."'");
		
        //$bno변수에 저장된 글 번호와 board테이블의 idx값과 같은것을 가져온다
        $sql = mq("select * from board where idx='".$bno."'");
		$board = $sql->fetch_array();
	?>

<!-- 상세보기 : 게시글 불러오기 -->
<div id="board_read">
	<h2><?php echo $board['title']; ?></h2>

	    <div id="user_info">
			<?php echo $board['name']; ?> <?php echo $board['date']; ?> 조회:<?php echo $board['hit']; ?> 추천:<?php echo $board['thumbup'];?>
				<div id="bo_line"></div>
	        </div>
			<div id="bo_content">
				<?php echo nl2br("$board[content]"); ?>  <!--nl2br이란 php함수이며 새로운 줄을 표시하는 기호를 HTML에서 인식 할 수 있도록 br태그로 변환해주는 역할-->
			</div>

	<!-- 목록, 수정, 삭제 링크 -->
	<div id="bo_ser">
		<ul>
			<li><a href="../../index.php">[목록으로..] </a></li>
			<!--추천, 수정, 삭제 버튼 클릭시 해당 글의 idx를 넘긴다-->
			<li><a href="thumbup.php?idx=<?php echo $board['idx']; ?>"> [*추천*]</a></li>
			<li><a href="modify.php?idx=<?php echo $board['idx']; ?>"> [수정] </a></li>
			<li><a href="delete.php?idx=<?php echo $board['idx']; ?>"> [삭제]</a></li>
		</ul>
	</div>
</div>
<!--- 댓글 불러오기 -->
<div class="reply_view">
	<h3>댓글목록</h3>
		<?php
			$sql3 = mq("select * from reply where con_num='".$bno."' order by idx desc");
			while($reply = $sql3->fetch_array()){ 
		?>
		<div class="dap_lo">
			<div><b><?php echo $reply['name'];?></b></div>
			<div class="dap_to comt_edit"><?php echo nl2br("$reply[content]"); ?></div>
			<div class="rep_me dap_to"><?php echo $reply['date']; ?></div>
			<div class="rep_me rep_menu">
				<a class="dat_edit_bt" href="#">수정</a>
				<a class="dat_delete_bt" href="#">삭제</a>
			</div>
			<!-- 댓글 수정 폼 dialog -->
			<div class="dat_edit">
				<form method="post" action="rep_modify_ok.php">
					<input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="b_no" value="<?php echo $bno; ?>">
					<input type="password" name="pw" class="dap_sm" placeholder="비밀번호" />
					<textarea name="content" class="dap_edit_t"><?php echo $reply['content']; ?></textarea>
					<input type="submit" value="수정하기" class="re_mo_bt">
				</form>
			</div>
			<!-- 댓글 삭제 비밀번호 확인 -->
			<div class='dat_delete'>
				<form action="reply_delete.php" method="post">
					<input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="b_no" value="<?php echo $bno; ?>">
			 		<p>비밀번호<input type="password" name="pw" /> <input type="submit" value="확인"></p>
				 </form>
			</div>
		</div>
	<?php } ?>

	<!--- 댓글 입력 폼 -->
	<div class="dap_ins">
		<form action="reply_ok.php?idx=<?php echo $bno; ?>" method="post">
			<input type="text" name="dat_user" id="dat_user" class="dat_user" size="15" placeholder="아이디">
			<input type="password" name="dat_pw" id="dat_pw" class="dat_pw" size="15" placeholder="비밀번호">
			<div style="margin-top:10px; ">
				<textarea name="content" class="reply_content" id="re_content" ></textarea>
				<button id="rep_bt" class="re_bt">댓글</button>
			</div>
		</form>
	</div>
</div><!--- 댓글 불러오기 끝 -->
<div id="foot_box"></div>
</div>
</body>
</html>