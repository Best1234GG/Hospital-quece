<?php

    if ($open_connet != 1){
        die(header('Location: login.php'));
    }



    $sever = "localhost";
    $username = "root";
    $pass = "";
    $dbname = "register";
    $port = NULL;
    $socket = NULL;
    $conn = mysqli_connect($sever, $username, $pass, $dbname);
    
    if (!$conn) {
        die("connect error  : ". mysqli_connect_error($conn));
    }else{
        mysqli_set_charset($conn, 'utf8');
        $count_error = 5;
        $time = 5;
        $query = "UPDATE account SET `lock` = 0 WHERE ban <= NOW() AND login_error >= '5'";
        mysqli_query($conn, $query);        
    }
?>