<?php 
require("../database/config.php");
unset($_SESSION['student_id']);
unset($_SESSION['student']);
header("Location:../index.php");

?>