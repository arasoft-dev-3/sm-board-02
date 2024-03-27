<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php";

$bid=$_GET["bid"];
$result = $mysqli->query("select * from board where bid=".$bid) or die("query error => ".$mysqli->error);
$rs = $result->fetch_object();

// 댓글 데이터를 가져옵니다.
$memoResult = $mysqli->query("SELECT * FROM memo WHERE bid=".$bid) or die("query error => ".$mysqli->error);
$memoArray = $memoResult->fetch_all(MYSQLI_ASSOC);

?>

<h3 class="pb-4 mb-4 fst-italic border-bottom" style="text-align:center;">
  - 게시판 보기 -
</h3>

<article class="blog-post">
  <h2 class="blog-post-title"><?php echo $rs->subject;?></h2>
  <p class="blog-post-meta"><?php echo $rs->regdate;?> by <a href="#"><?php echo $rs->userid;?></a></p>
  <hr>
  <p>
    <?php echo $rs->content;?>
  </p>
  <hr>
</article>
<nav class="blog-pagination" aria-label="Pagination">
  <a class="btn btn-outline-secondary" href="index">목록</a>
  <a class="btn btn-outline-secondary" href="write?parent_id=<?php echo $rs->bid;?>">답글</a>
  <a class="btn btn-outline-secondary" href="write?bid=<?php echo $rs->bid;?>">수정</a>
  <a class="btn btn-outline-secondary" href="delete?bid=<?php echo $rs->bid;?>">삭제</a>
</nav>

<!-- 댓글 등록 -->
<div style="margin-top:20px;">
  <form class="row g-3">
    <div class="col-md-10">
      <textarea class="form-control" placeholder="댓글을 입력해주세요." id="floatingTextarea2" style="height: 60px"></textarea>
    </div>
    <div class="col-md-2">
      <button type="button" class="btn btn-secondary" id="memo_button">댓글등록</button>
    </div>
  </form>
</div>

<div id="memo_place">
  <?php
        foreach($memoArray as $ma){
      ?>
  <div class="card mb-4" style="max-width: 100%;margin-top:20px;">
    <div class="row g-0">
      <div class="col-md-12">
        <div class="card-body">
          <p class="card-text"><?php echo $ma['memo'];?></p>
          <p class="card-text"><small class="text-muted">
              <?php echo $ma['userid'];?> / <?php echo $ma['regdate'];?></small>
          </p>
        </div>
      </div>
    </div>
  </div>
  <?php }?>
</div>

<script>
$("#memo_button").click(function() {
  var data = {
    memo: $('#floatingTextarea2').val(),
    bid: <?php echo $bid;?>
  };
  $.ajax({
    url: 'memo_write',
    type: 'POST',
    data: data,
    success: function(return_data) {
      if (return_data == "member") {
        alert('로그인 하십시오.');
        return;
      } else {
        $("#memo_place").append(return_data);
      }
    },
    error: function() {
      console.error('AJAX 요청 실패');
    }
  });
});
</script>

<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>