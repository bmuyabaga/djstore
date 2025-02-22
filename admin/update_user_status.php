<?php

//order_fetch.php

include('../config/function.php');


$time=time() + 10;
$userid = $_SESSION['user_id'];



 $query = "
 UPDATE user_details SET last_login = '".$time."' WHERE user_id='".$_SESSION['user_id']."'

";

$statement = $connect->prepare($query);
$result = $statement->execute();
$result=$statement->fetchAll();
?>