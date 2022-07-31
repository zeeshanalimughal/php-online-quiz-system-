<?php 
require("../database/config.php");
if(!isset($_SESSION['admin'])){
  header('Location:logout.php');
}

if(isset($_GET['id'])){
    $deleteSql = "DELETE FROM course WHERE id = {$_GET['id']} ";
    if(mysqli_query($conn,$deleteSql)){
        $_SESSION['course'] = "course Deleted Successfully";
        header("Location:courses.php");
    }
}

?>