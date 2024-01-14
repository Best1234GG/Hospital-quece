<?php
    session_start();
    $open_connect = 1;

    require('connect.php');

    if(isset($_POST['email']) && isset($_POST['password'])) {
        $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
        $password = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']));
        $check_account = "SELECT * FROM account WHERE email = '$email'";
        $call_check = mysqli_query($conn, $check_account);
        if(mysqli_num_rows($call_check) == 1){
            $result = mysqli_fetch_assoc($call_check);
            $hash = $result['password'];
            $password = $password . $result['salt'];
            $conut = $result['login_error'];
            $ban = $result['ban'];
            if($result['lock'] == 1){
                echo '<h1>บัญชีถูกระงับชั่วคราว(Account has been temporarily suspended.)</h1>';
                echo  "<h1>ถูกระงับเป็นเวลา $time นาที เนื่องจากมีการกรอกผู้ใช้หรือรหัสผ่านผิดจำนวน $count ครั้ง</h1>";
                echo "<h2>จะถูกปลดเมื่อเวลา $ban";
                echo '<a href="login.php">';
            }elseif (password_verify($password, $hash)){
                $reset = "UPDATE account SET login_error = 0 WHERE email = '$email'";
                $result_reset = mysqli_query($conn, $reset);
                if ($result['role'] == 'member'){
                    $_SESSION['id'] = $result['id'];
                    $_SESSION['role'] = $result['role'];
                    die(header('Location: index.php'));
                }elseif($result['role'] == 'admin'){
                    $_SESSION['id'] = $result['id'];
                    $_SESSION['role'] = $result['role'];
                    die(header('Location: admin.php'));
                }
            }else{
                $query_login_count =  "UPDATE account SET login_error + 1 WHERE email = '$email'";
                $call_login_error = mysqli_query($conn, $query_login_count);
                if ($result['login_error'] + 1 >= $count_error){
                    $ban_account = "UPDATE account SET lock = 1, ban = DATE_ADD(NOW(), INTERVAL $time MINUTE) WHERE email = '$email'";
                    $result_ban = mysqli_query($conn, $ban_account);
                }
                die(header('Location: login.php'));
            }
        }else{
            die(header('Location: login.php'));
        }

    }else{
        die(header('Location: login.php'));
    }
?>