<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php";

$bid=$_GET["bid"];
$result = $mysqli->query("select * from board where bid=".$bid) or die("query error => ".$mysqli->error);
$rs = $result->fetch_object();

// echo "<pre>";
// print_r($rs);

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

<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>