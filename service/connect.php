<?php
    $conn = mysqli_connect('localhost','root', '1234', 'clothing_store_db','3306');
    if(!$conn){
        echo "Something Wrong In Connection..";
    }else{
        echo "Connect successs..";
    }

?>