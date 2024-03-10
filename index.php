<?php
include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php";

// $result = $mysqli->query("select * from board where status=1 order by bid desc") or die("query error => " . $mysqli->error);
// while ($rs = $result->fetch_object()) {
//   $rsc[] = $rs;
// }

$search_keyword = isset($_GET['search_keyword']) ? $_GET['search_keyword'] : '';
$search_where = '';

if($search_keyword){
  $search_where = " and (subject like '%".$search_keyword."%' or content like '%".$search_keyword."%')";
}

$sql = "select * from board where 1=1";
$sql .= " and status=1";
$sql .= $search_where;
//$order = " order by bid desc";
$order = " order by ifnull(parent_id, bid) desc, bid asc";
$query = $sql.$order;
//echo "query=>".$query."<br>";
$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
while($rs = $result->fetch_object()){
  $rsc[]=$rs;
}

// $userid = $_SESSION['UID'];
//   echo "현재 접속 ID : ".$userid;
$userid = isset($_SESSION['UID']) ? $_SESSION['UID'] : '';


  // echo "<pre>";
// print_r($rsc);

?>
<div>
  <?php if(isset($_SESSION['UID'])) {
  echo "id : ".$userid;
  }
  ?>
</div>

<table class="table" style="">
  <thead>
    <tr>
      <th scope="col">번호</th>
      <th scope="col">글쓴이</th>
      <th scope="col">제목</th>
      <th scope="col">등록일</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $i=1;
      foreach($rsc as $r){
        //검색어만 하이라이트 해준다.
        $subject = str_replace($search_keyword,"<span style='color:red;'>".$search_keyword."</span>",$r->subject);
    ?>

    <tr>
      <th scope="row">
        <?php echo $i++ ?>
      </th>
      <td>
        <?php echo $r->userid ?>
      </td>
      <td>
        <?php if($r->parent_id) { echo "&nbsp;&nbsp;"; } ?>
        <a href="view?bid=<?php echo $r->bid; ?>">
          <?php echo $subject ?>
        </a>
      </td>
      <td>
        <?php echo $r->regdate ?>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<form method="get" action="<?php echo $_SERVER["PHP_SELF"]?>">
  <div class="input-group mb-12" style="margin:auto;width:50%;">
    <input type="text" class="form-control" name="search_keyword" id="search_keyword" placeholder="제목과 내용에서 검색합니다." value="<?php echo $search_keyword;?>" aria-label="Recipient's username" aria-describedby="button-addon2">
    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">검색</button>
  </div>
</form>

<p style="text-align:right;">

  <?php
  if (isset($_SESSION['UID'])) {//세션값이 있는지 여부를 확인해서 로그인 했는지를 체크한다.
  ?>
    <a href="write"><button type="button" class="btn btn-primary">등록</button><a>
    <a href="member/logout"><button type="button" class="btn btn-primary">로그아웃</button><a>
  <?php
  } else {
  ?>
    <a href="member/login"><button type="button" class="btn btn-primary">로그인</button><a>
    <a href="member/signup"><button type="button" class="btn btn-primary">회원가입</button><a>
  <?php
  }
  ?>
</p>

<?php
include $_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php";
?>