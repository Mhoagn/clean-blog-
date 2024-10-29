<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php

  $posts = $con->prepare("SELECT p.*, u.username FROM posts p 
  JOIN users u 
  ON u.id = p.user_id");

  $posts->execute();
  $rows = $posts->fetchAll(PDO::FETCH_OBJ);

  $categories = $con->prepare("SELECT * FROM categories");
  $categories->execute();
  $category = $categories->fetchAll(PDO::FETCH_OBJ);
  

?>

<?php
    if(isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
?>
      <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">


        <?php foreach($rows as $row) : ?> 
          <!-- Post preview-->
          <div class="post-preview">
          <a href="posts/post.php?post_id=<?php echo $row->id; ?>">
              <h2 class="post-title">
                <?php echo "<strong>{$row->title}</strong>"; ?>
              </h2>
              <h3 class="post-subtitle">
              <?php echo $row->subtitle; ?>
              </h3>
            </a>
            <p class="post-meta">
              Posted by 
              <a href="#!"><?php echo $row->username; ?></a>
              <?php echo date('M',strtotime($row->created_at)) . ', ' . date('d',strtotime($row->created_at)) . ', ' . date('Y',strtotime($row->created_at));  ?>
            </p>
          </div>
          <!-- Divider-->
          <hr class="my-4" />
          <!-- Post preview-->
         <?php endforeach; ?>
          <!-- Pager-->
        </div>
      </div>
        <div class="row gx-4 gx-lg-5 justify-content-center">  
          <h3>Categories</h3>
          <br>  
        <?php foreach($category as $cat) : ?>   
          <div class="col-md-6">
          <a href="categories/category.php?cat_id=<?php echo $cat->category_id; ?>"> 
            <div class="alert alert-dark bg-dark text-center text-white" role="alert">
              <?php echo $cat->name; ?>
            </div>
            </a>
          </div>
        <?php endforeach; ?>
        </div>  

      <?php require "includes/footer.php"; ?>
