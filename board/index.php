<!--index.php
게시판 목록 페이지 입니다.
-->
<?php
	include $_SERVER['DOCUMENT_ROOT']."/board/db.php"; /* db load */
?>

<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
<div id="board_area"> 
  <h1>정보_공유</h1>
  <h4>우리 모두 공유합시다!</h4>
    <table class="list-table">
      <thead>
          <tr>
              <th width="70">번호</th>
                <th width="500">제목</th>
                <th width="120">글쓴이</th>
                <th width="100">작성일</th>
                <th width="100">조회수</th>
                <th width="100">추천수</th>
            </tr>
        </thead>

<!--페이징-->
        <?php
            if(isset($_GET['page'])){
              $page = $_GET['page'];
                }else{
                  $page = 1;
                }
                  $sql = mq("select * from board");
                  $row_num = mysqli_num_rows($sql); //게시판 총 레코드 수
                  $list = 10; //한 페이지에 보여줄 개수
                  $block_ct = 5; //블록당 보여줄 페이지 개수
    
                  $block_num = ceil($page/$block_ct); // 현재 페이지 블록 구하기 : page를 5로 나눈 값을 올림한다
                  $block_start = (($block_num - 1) * $block_ct) + 1; // 블록의 시작번호
                  $block_end = $block_start + $block_ct - 1; //블록 마지막 번호
    
                  $total_page = ceil($row_num / $list); // 페이징한 페이지 수 구하기 = 전체 게시물 수/10 를 올림한다

                  if($block_end > $total_page) $block_end = $total_page; //만약 블록의 마지막 번호 > 필요한 페이지수 라면 마지막 블록번호 전체 페이지수로 변경

                  $total_block = ceil($total_page/$block_ct); //블럭 총 개수 = 전체 페이지 수/5개 를 올림한다
                  
                  $start_num = ($page-1) * $list; //한페이지에 보여줄 시작 페이지번호= (page-1)에서 $list를 곱한다.


        // board테이블에서 idx를 기준으로 내림차순해서 10개까지 표시
            //$sql2 = mq("select * from board order by idx desc limit 0,10");
            $sql2 = mq("select * from board order by idx desc limit $start_num, $list");
    
          
            while($board = $sql2->fetch_array())
            {

              //title변수에 DB에서 가져온 title을 선택
              $title=$board["title"]; 

              // ************수빈 댓글 개수 알림 코드 수정
              $con_idx = $board["idx"];
              $reply_count = mq("select count(*) as cnt from reply where con_num=$con_idx");
              $con_reply_count = $reply_count->fetch_array();

              //title이 30을 넘어서면 ...표시
              if(strlen($title)>30)
              { 
                $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
              }
            ?>
        <tbody>
          <tr>
            <td width="70"><?php echo $board['idx']; ?></td>
              <!--title클릭시 read.php로 연결, 글의 idx 전달-->
            <!--수빈 수정완료-->
            <td width="500"><?php
            if($board['lock_post']=="1")
            {?><a href="./page/board/ck_read.php?idx=<?php echo $board["idx"];?>"><?php echo $title."[".$con_reply_count["cnt"]."]"; //con_reply_count 수정
              }else{ ?>
            <a href="./page/board/read.php?idx=<?php echo $board["idx"];?>"><?php echo $title."[".$con_reply_count["cnt"]."]";}?></a></td><!--con_reply_count 수정-->
            <td width="120"><?php echo $board['name']?></td>
            <td width="100"><?php echo $board['date']?></td>
            <td width="100"><?php echo $board['hit']; ?></td>
            <!-- 추천수 표시 -->
            <td width="100"><?php echo $board['thumbup']?></td>
          </tr>
        </tbody>
      <?php } ?>

    </table>
    
<!---페이징 넘버 --->
<div id="page_num">
      <ul>
        <?php

        //처음 버튼 만들기
          if($page <= 1)
          { //만약 page가 1보다 크거나 같다면
            echo "<li class='fo_re'>처음</li>"; //처음이라는 글자에 빨간색 표시 
          }else{
            echo "<li><a href='?page=1'>처음</a></li>"; //아니라면 처음글자에 1번페이지로 갈 수있게 링크
          }
          
        //이전 페이지 링크하기
          if($page <= 1)
          {
            //1번페이지일 경우 이전글씨 필요x
          }else{
            $pre = $page-1; //이전 페이지 번호
            echo "<li><a href='?page=$pre'>이전</a></li>"; //이전글자에 pre변수를 링크
          }
        
        //현재 페이지 번호 빨간색으로 표시하기
          for($i=$block_start; $i<=$block_end; $i++){ 
            //초기값을 블록의 시작번호~마지박블록
            if($page == $i){ //만약 현재page가 $i와 같다면 
              echo "<li class='fo_re'>[$i]</li>"; //class를 지정해서 굵은 빨간색을 적용
            }else{
              echo "<li><a href='?page=$i'>[$i]</a></li>";
            }
          }
        
        //다음 페이지 링크하기
          if($block_num >= $total_block){ 
            //마지막 블록이라면 다음페이지 없음
          }else{
            $next = $page + 1; // 다음 페이지 번호
            echo "<li><a href='?page=$next'>다음</a></li>"; //다음글자에 next변수를 링크
          }
        
        //마지막 버튼 만들기
          if($page >= $total_page){ 
            // 마지막 페이지라면
            echo "<li class='fo_re'>마지막</li>"; //마지막 글자에 긁은 빨간색을 적용
          }else{
            echo "<li><a href='?page=$total_page'>마지막</a></li>"; //\마지막글자에 total_page를 링크
          }
        ?>
      </ul>
    </div>
    
    <div id="write_btn">
      <a href="./page/board/write.php"><button>글쓰기</button></a>
    </div>
  </div>
</body>
</html>