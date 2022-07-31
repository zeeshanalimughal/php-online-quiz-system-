<?php 
require("../database/config.php");
unset( $_SESSION['teacher'] );
unset($_SESSION['teacher_id']);
header("Location:../index.php");

?>