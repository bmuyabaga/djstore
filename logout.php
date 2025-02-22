<?php
//logout.php
require 'config/function.php';

session_destroy();

header("location:login.php");

?>