<?php 
require("../database/config.php");
unset( $_SESSION['admin'] );
unset($_SESSION['admin_id']);
header("Location:../index.php");

?>