<?php
require_once "inc/conn.php";


if (isset($_SESSION['succes'])) { ?>

   <div class="alert alert-success "><?php echo $_SESSION['succes'] ?></div>

<?php    }
unset($_SESSION['succes']);






?>