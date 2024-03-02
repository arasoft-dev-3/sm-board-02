<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";

if(!$_SESSION['UID']){
    echo "<script>alert('회원 전용 게시판입니다.');location.href='index';</script>";
    exit;
}

$subject=$_POST["subject"];
$content=$_POST["content"];
$bid=$_POST["bid"];//bid값이 있으면 수정이고 아니면 등록이다.
$userid=$_SESSION['UID'];//userid는 세션값으로 넣어준다.
$status=1;//status는 1이면 true, 0이면 false이다.

if($bid){//bid값이 있으면 수정이고 아니면 등록이다.
    $result = $mysqli->query("select * from board where bid=".$bid) or die("query error => ".$mysqli->error);
    $rs = $result->fetch_object();

    if($rs->userid!=$_SESSION['UID']){
        echo "<script>alert('본인 글이 아니면 수정할 수 없습니다.');location.href='index';</script>";
        exit;
    }
    $sql="update board set subject='".$subject."', content='".$content."' where bid=".$bid;//수정하기
}else{
    $sql="insert into board (userid,subject,content) values ('".$userid."','".$subject."','".$content."')";//등록하기
}
$result=$mysqli->query($sql) or die($mysqli->error);

if($result){
    echo "<script>location.href='index';</script>";
    exit;
}else{
    echo "<script>alert('글등록에 실패했습니다.');history.back();</script>";
    exit;
}
?>