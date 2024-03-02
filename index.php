<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php";

$result = $mysqli->query("select * from board") or die("query error => ".$mysqli->error);
while($rs = $result->fetch_object()){
    $rsc[]=$rs;
}

// echo "<pre>";
// print_r($rsc);

?>

    <table class="table" style="width:70%;margin:auto;">
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
      $i = 1;
      foreach($rsc as $r) { ?>
        <tr>
          <th scope="row"><?php echo $i++ ?></th>
          <td><?php echo $r->userid ?></td>
          <td>
            <a href="view?bid=<?php echo $r->bid; ?>">
              <?php echo $r->subject ?>
            </a>
          </td>
          <td><?php echo $r->regdate ?></td>
        </tr>
      <?php } ?>
    </tbody>
    </table>
    <div class="col-md-4" style="float:right;padding:20px;">
    <a href="write"><button type="button" class="btn btn-primary">등록</button></a>

<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>