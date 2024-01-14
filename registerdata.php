<?php
    $open_connet = 1;
    require('connect.php');
    if(isset($_POST['user']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordagain'])){
        $user = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['user']));
        $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
        $password1 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']));
        $password2 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['passwordagain']));
        if (empty($user)){
            die(header('Location: register.php'));
        }elseif(empty($email)){
            die(header('Location: register.php'));
        }
        elseif(empty($password1)){
            die(header('Location: register.php'));
        }
        elseif(empty($password2)){
            die(header('Location: register.php'));
        }else if ($password1 != $password2){
            die(header('Location: register.php'));
        }else{
            $check_email = "SELECT email FROM account WHERE email = '$email'";
            $check_call = mysqli_query($conn, $check_email);
            if (mysqli_num_rows($check_call) > 0) {
                die(header('Location: register.php'));
            }else{
                $len = random_int(97,128);
                $salt = bin2hex(random_bytes($len));
                $password1 = $password1 . $salt;
                $algo = PASSWORD_ARGON2ID;
                $options = [
                    'cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
                    'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
                    'thread' => PASSWORD_ARGON2_DEFAULT_THREADS
                ];
                $password = password_hash($password1, $algo, $options);
                $crate_account = "INSERT INTO account VALUE (
                '',
                '$user',
                '$email',
                '$password',
                '$salt',
                'member',
                'default_image_account.jpg',
                '',
                '',
                '')";
                $call_account = mysqli_query($conn, $crate_account);
                if ($call_account){
                    die(header('Location: login.php'));
                }else{
                    die(header('Location: register.php'));
                }
            }
        }
    }else{
        die(header('Location: register.php'));
    }
?>
