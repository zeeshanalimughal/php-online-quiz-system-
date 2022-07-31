<?php 
require("../database/config.php");
if(!isset($_SESSION['teacher'])){
  header('Location:logout.php');
}

if(isset($_GET['qid']))
{
    $qid = $_GET['qid'];
    $sql = "UPDATE quizlist SET status = 0 WHERE quiz_id = $qid";
    if(mysqli_query($conn,$sql)){
        $_SESSION['registered'] = "Quiz Disabled Sucessfully";
        header("Location:quiz-list.php");
    }
}
?>