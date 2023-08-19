        <?php
            
        require_once '../inc/conn.php';
        if(! isset($_SESSION['user_id'])){
            header('Location:Login.php');
          }else{
          $user_id = $_SESSION['user_id'];
        //insert --> (1-check submit , 2-catch , 3- validation , errors empty -> insert);

        if (isset($_POST['submit'])) {
            $title = trim(htmlspecialchars($_POST['title']));
            $body = trim(htmlspecialchars($_POST['body']));
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
                $newName = null;
            }
            if (empty($errors)) {
                // insert
                $quary = "insert into posts(`title`,`image`,`body`,`user_id`)values('$title','$newName','$body','$user_id') ";
                $result = mysqli_query($conn, $quary);
                if ($result) {
                    if (isset($_FILES['image']) && $_FILES['image']['name']) {
                        move_uploaded_file($image_tmpname, "../assets/images/postImage/$newName");
                    }
                    $_SESSION['succes'] = "post insert succssfuly";
                    header("location:../index.php");
                } else {
                    $_SESSION['errors'] = ["error while insert"];
                }
            } else {
                $_SESSION['errors'] = $errors;
                header("location:../addPost.php");
            }
        } else {
            header("location:../addPost.php");
        }
     
        }               