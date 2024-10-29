<?php require "layouts/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
  if(!isset($_SESSION['admin_name'])){
    header("location: admins/login-admins.php");
  }

  $query_count_posts = $con->prepare("SELECT COUNT(*) AS total_posts FROM posts");
  $query_count_posts->execute();
  $count_post = $query_count_posts->fetch(PDO::FETCH_OBJ);

  $query_count_categories = $con->prepare("SELECT COUNT(*) AS total_categories FROM categories");
  $query_count_categories->execute();
  $count_category = $query_count_categories->fetch(PDO::FETCH_OBJ);

  $query_count_admins = $con->prepare("SELECT COUNT(*) AS total_admins FROM admins");
  $query_count_admins->execute();
  $count_admin = $query_count_admins->fetch(PDO::FETCH_OBJ);



?>



            
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Posts</h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">number of posts: <?php echo $count_post->total_posts; ?></p>
             
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Categories</h5>
              
              <p class="card-text">number of categories: <?php echo $count_category->total_categories; ?> </p>
              
              
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admins</h5>
              
              <p class="card-text">number of admins: <?php echo $count_admin->total_admins; ?> </p>
              
            </div>
          </div>
        </div>
      </div>
     

<?php require "layouts/footer.php"; ?>
            