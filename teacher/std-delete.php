<?php 
require("../database/config.php");
if(!isset($_SESSION['teacher'])){
  header('Location:logout.php');
}
if(isset($_GET['id'])){
    $deleteSql = "DELETE FROM student WHERE s_id = {$_GET['id']} ";
    if(mysqli_query($conn,$deleteSql)){
        $_SESSION['registered'] = "Student Deleted Successfully";
        header("Location:students.php");
    }
}

?>