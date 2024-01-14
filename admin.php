<?php
    session_start();
    require('connect.php');
    $open_connect = 1;
    if (!isset($_SESSION['id']) || isset($_SESSION['role']) != 'admin') {
        die(header('Location: login.php'));
    }elseif(isset($_GET['logout'])){
        session_destroy();
        die(header('Location: login.php'));
    }else{
        $od = $_SESSION['id'];
        $show = "SELECT * FROM account WHERE id = '$id'";
        $call_show = mysqli_query($con, $show);
        $result_show = mysqli_fetch_assoc($call_show);
        $direc = 'image/'; 
        $image_name = $direc . $result_show['image'];
        $clear_img = '?' . filemtime($image_name);
        $img_account = $image_name . $clear_img;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href = "icon\icon.jpg">
    <title>ADMIN</title>
</head>
<body>
    <img src="<?php
        echo $image_name;
    ?>">
    <h1>WELCOME <?php echo $result_show['user'];?> สถานะ :  <?php echo $result_show['role'];?></h1>
    <a href="admin.php?logout=1">Sign OUT</a>
</body>
</html>