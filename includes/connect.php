<?php 
$con = new mysqli('localhost:3308','root','','primetextiles');
if(!$con){
    die(mysqli_error($con));
}
define('BASE_URL', '/PrimeTextiles');




?>