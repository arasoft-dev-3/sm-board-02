<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";

// echo "<pre>";
// print_r($_POST);

$subject=$_POST["subject"];
$content=$_POST["content"];
$userid="LEE";//userid는 없어서 임의로 넣어줬다.
$status=1;//status는 1이면 true, 0이면 false이다.

// echo "<br>------<br>";

// echo "제목=>".$subject."<br>";
// echo "내용=>".$content;

$sql="insert into board (userid,subject,content) values ('".$userid."','".$subject."','".$content."')";
$result=$mysqli->query($sql) or die($mysqli->error);

//echo "결과=>".$result;

if($result){
    echo "<script>location.href='index';</script>";
    exit;
}else{
    echo "<script>alert('글등록에 실패했습니다.');history.back();</script>";
    exit;
}

?>