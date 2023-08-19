<?php     
require_once 'inc/conn.php';

if(! isset($_SESSION['user_id'])){
  header('Location:Login.php');
}

?>
<?php require_once 'inc/header.php' ?>

    <!-- Page Content -->
    <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4><?php echo $msg['new Post']?></h4>
              <h2>add new personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container w-50 ">
  <?php
    require_once "inc/errors.php";
    ?>
    
  <div class="d-flex justify-content-center">
    <h3 class="my-5"><?php echo $msg['new Post']?></h3>
  </div>
  <form method="POST" action="handle/handleAddPost.php" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label"><?php echo $msg['title']?></label>
        <input type="text" class="form-control" id="title" name="title" value="">
    </div>
    <div class="mb-3">
        <label for="body" class="form-label"><?php echo $msg['body']?></label>
        <textarea class="form-control" id="body" name="body" rows="5"></textarea>
    </div>
    <div class="mb-3">
        <label for="body" class="form-label"><?php echo $msg['image']?></label>
        <input type="file" class="form-control-file" id="image" name="image" >
    </div>
    <!-- <img src="uploads/<?php echo $post['image'] ?>" alt="" width="100px" srcset=""> -->
    <button type="submit" class="btn btn-primary" name="submit"><?php echo $msg['submit']?></button>
  </form>
</div>

    <?php require_once 'inc/footer.php' ?>
