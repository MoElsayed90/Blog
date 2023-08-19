<?php

require_once '../inc/conn.php';

if(! isset($_SESSION['user_id'])){
    header('Location:../Login.php');
  }else {

  

if (!isset($_GET['id'])) {
    header("location:index.php");
  }
  $id = $_GET['id'];
  $quary = "select * from posts where id=$id";
  $result = mysqli_query($conn,$quary);

  if (mysqli_num_rows($result)==1) {
  $oldImage = mysqli_fetch_assoc($result)['image'];
    
        if (!empty($oldImage)) {
            unlink("../assets/images/postImage/$oldImage");
        }

        $quary = "delete from posts where id=$id";
        $result=mysqli_query($conn, $quary);

        if ($result) {
            $_SESSION['succes']='post deleted successfuly';
            header("location:../index.php");            
        }

}else {
    $_SESSION['errors']=['error while delete'];
    header("location:../index.php");
  }
}