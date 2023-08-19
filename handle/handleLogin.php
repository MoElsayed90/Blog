<?php 
require_once '../inc/conn.php';


    if(isset($_POST['submit'])){
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $errors = [];

    if(empty($email)){
        $errors[] = "email is requarid";
    }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors[] = " must be email";
    }elseif (!is_string($email)) {
        $errors[] = "email must be string";
    }

    if (empty($password)) {
        $errors[] = "Password is requarid";
        
    }elseif (strlen($password)<6) {
        $errors[] = "password must be more than 7 char";
        
    }
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['email']=$email;
        
        header("Location:../Login.php");
    }
        $quary = "select * from users where `email`='$email'";
        $result = mysqli_query($conn,$quary);

        if (mysqli_num_rows($result)==1) { //true
            $user = mysqli_fetch_assoc($result);
            $name = $user['name'];
            $oldPassword = $user['password'];
            $id = $user['id'];

            $verify = password_verify($password,$oldPassword);

            if ($verify) {
                $_SESSION['user_id'] = $id ;
                $_SESSION['succes']="welcome $name";
                header("location:../index.php");
            }else{
            $_SESSION['errors']=['email or password not correct pass'];
            header("location:../Login.php");

            }
            
        }else {
            $_SESSION['errors']=['email or password not correct email'];
            header("location:../Login.php");
        }



    



    }else {
    header("location:../Login.php");
    }