<?php require_once 'service/connect.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/common.css">
    <title>Document</title>
</head>
<body>
    <?php require_once 'include/header.php' ?>
    <div class="products">
        <?php
            $sql = "SELECT * FROM product";
            $result = $conn->query($sql);

            while($rec = $result->fetch_assoc()){
                echo"
                    <div class='product'>
                        <p>{$rec['Name']}</p>
                        <p>{$rec['Description']}</p>
                        <p>{$rec['Price']}</p>
                        <input type='submit' value='Cart' action='' name='cartSubmit' method='GET'>
                    </div>
                ";
            }
        ?>
        
    </div>
</body>
</html>