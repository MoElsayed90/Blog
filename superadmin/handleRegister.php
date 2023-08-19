<?php
require_once "../inc/conn.php";

if(isset($_POST['submit'])){
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $phone = trim(htmlspecialchars($_POST['phone']));
    $errors = [];



    //validation 

    if(empty($name)){
        $errors[] = "name is requarid";
    }elseif (strlen($name)<3) {
        $errors[] = "name must be more than 6 char";
    
    }elseif (!is_string($name)) {
        $errors[] = "name must be string";
    }
    
    
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
    

    if (empty($phone)) {
        $errors[] = "Phone number is requarid";
    }elseif (strlen($phone)!=11) {
        $errors[] = "phone must be 11 char";
        
    }
    

        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['name']=$name;
            $_SESSION['email']=$email;
            $_SESSION['hashedPassword']=$hashedPassword;
            $_SESSION['phone']=$phone;
            header("Location:register.php");
        
        }else {
 
            
            
            $quary = "insert into users (`name`,`email`,`password`,`phone`) values ('$name','$email','$hashedPassword','$phone')";
            
            $result = mysqli_query($conn,$quary);
            
            if ($result) {
                header("location:../Login.php");
            }else {
                header("Location:register.php");
                
            }
        }


}else {
    header("Location:register.php");
}