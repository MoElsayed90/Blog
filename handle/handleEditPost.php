<?php

require_once '../inc/conn.php';



// submit , id , check , selectone , catch , validation , update


if (isset($_POST['submit']) && isset($_GET['id'])) {


    $title = trim(htmlspecialchars($_POST['title']));
    $body = trim(htmlspecialchars($_POST['body']));

    $id = $_GET['id'];
    $quary = "select * from posts where id=$id";
    $result = mysqli_query($conn,$quary);

    if (mysqli_num_rows($result)==1) {
        //update
        $oldimage = mysqli_fetch_assoc($result)['image'];


        $errors = [];

        if (empty($title)) {
            $errors[] = 'Title is required!';
        } elseif (is_numeric($title)) {
            $errors[] = "title must be string";
        }


        if (empty($body)) {
            $errors[] = 'body is required!';
        } elseif (is_numeric($body)) {
            $errors[] = "body must be string";
        }

        if (isset($_FILES['image']) && $_FILES['image']['name']) {

            $image = $_FILES['image'];
            $image_name = $image['name'];
            $image_tmpname = $image['tmp_name'];
            $image_error = $image['error'];
            $image_size = $image['size'] / (1024 * 1024);
            $ext = Strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            $newName = uniqid() . "." . $ext;

            if ($image_error != 0) {
                $errors[] = "image requried";
            } elseif ($image_size > 1) {
                $errors[] = "image large size";
            } elseif (!in_array($ext, ["jpg", "jpeg", "gif", "png"])) {
                $errors[] = "invalid image type!";
            }
        } else {
            $newName = $oldimage;
        }

        if (empty($errors)) {
           $quary = "update posts set `title`='$title' , `image`='$newName' , `body`='$body' where id=$id ";
           $result = mysqli_query($conn,$quary );

           if ($result) {
            if (isset($_FILES['image']) && $_FILES['image']['name']) {
            unlink("../assets/images/postImage/$oldimage");
            move_uploaded_file($image_tmpname,"../assets/images/postImage/$newName");
            }

               $_SESSION['succes'] = "post updated successfuly";
            header("location:../viewPost.php?id=$id"); 
           }else {
            $_SESSION['errors'] = ['error while update'];
            header("location:../editPost.php?id=$id"); 
           }

        }else {
            $_SESSION['errors'] = $errors;
            header("location:../editPost.php?id=$id"); 
        }
    }else {
        $_SESSION['errors'] = ["post not found"];
        header("location:../index.php");
    }
}else {
    header("location:../index.php");
    
}
