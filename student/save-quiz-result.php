<?php
require("../database/config.php");
if(!isset($_SESSION['student'])){
header("Location:logout.php");
}

$quizId = $_GET['qid'];
$selectScorePerQuestion = "SELECT quiz_right_marks, quiz_wrong_marks FROM quizlist WHERE quiz_id = {$_GET['qid']}";
$scoreResult = mysqli_query($conn,$selectScorePerQuestion);
if($scoreResult){
    $scoresPerQuestion = mysqli_fetch_assoc($scoreResult);
}

$rightAnswers = $_SESSION['correct'];
$wrongAnswers = $_SESSION['wrong'];

$totQuestions = $rightAnswers+$wrongAnswers;

$totalScores = ($totQuestions * $scoresPerQuestion['quiz_right_marks'])-($scoresPerQuestion['quiz_wrong_marks'] * $wrongAnswers);


$insertIntoHistory = "INSERT INTO `history`(`s_id`, `quizId`, `tot_questions`, `scores`, `correct`, `wrong`, `history_status`) VALUES ({$_SESSION['student_id']},{$quizId},{$totQuestions},{$totalScores},{$rightAnswers},{$wrongAnswers},1)";
$res = mysqli_query($conn,$insertIntoHistory);
if($res){
    header("Location:quiz-result.php?qid={$quizId}");
}else{
    echo "Query unsuccessfull";
}

?>