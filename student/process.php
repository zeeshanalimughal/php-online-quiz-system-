<?php
require("../database/config.php");
if(!isset($_SESSION['student'])){
header("Location:logout.php");
}


if(isset($_GET['qid'])){
$next = (int)$_POST['number'];
$selected  =(int)$_POST['selected'];
$selectRight  = "SELECT option_number FROM quiz_answer WHERE qid = $next";
$res = mysqli_query($conn,$selectRight);
if($res){
    $answer = mysqli_fetch_array($res);
}
if($selected == $answer[0]){
    $_SESSION['correct']++;
}else{
   $_SESSION['wrong']++;
}

$_SESSION['next'] = $next+=1;
header("Location:solve-quiz.php?qid={$_GET['qid']}");
}
?>