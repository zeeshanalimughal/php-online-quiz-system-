<?php 
require("../database/config.php");
if(!isset($_SESSION['admin'])){
  header('Location:logout.php');
}

if(isset($_GET['id'])){
    $deleteSql = "DELETE FROM teacher WHERE t_id = {$_GET['id']} ";
    if(mysqli_query($conn,$deleteSql)){
        $_SESSION['registered'] = "Teacher Deleted Successfully";
        header("Location:teacher.php");
    }
}

?>