<?php 
require("../database/config.php");
if(!isset($_SESSION['teacher'])){
  header('Location:logout.php');
}
$quiz_id = $_GET['quiz_id'];
$_SESSION['count'] = 1;
header("Location:question-details.php?quiz_id={$quiz_id}");
?>