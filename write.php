<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php"; //header.php 파일안에 session_start()가 있음

if(!$_SESSION['UID']){
  echo "<script>alert('회원 전용 게시판입니다.');history.back();</script>";
  exit;
}

$bid = isset($_GET["bid"]) ? $_GET["bid"] : '';//get으로 넘겼으니 get으로 받는다.
$rs = new stdClass();
$rs->subject = '';
$rs->content = '';

if(isset($_GET["bid"])) {
  $bid=$_GET["bid"];
  if($bid){//bid가 있다는건 수정이라는 의미다.
    $result = $mysqli->query("select * from board where bid=".$bid) or die("query error => ".$mysqli->error);
    $rs = $result->fetch_object();
    if($rs->userid!=$_SESSION['UID']){
      echo "<script>alert('본인 글이 아니면 수정할 수 없습니다.');history.back();</script>";
      exit;
    }
  }
}



// echo "<pre>";
// print_r($rs);

?>

<form method="post" action="write_ok">
  <input type="hidden" name="bid" value="<?php echo $bid;?>">
  <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">제목</label>
    <input type="text" name="subject" class="form-control" id="exampleFormControlInput1" placeholder="제목을 입력하세요." value="<?php echo $rs->subject;?>">
  </div>
  <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">내용</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3"><?php echo $rs->content;?></textarea>
  </div>
  <button type="submit" class="btn btn-primary">등록</button>
</form>
<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>