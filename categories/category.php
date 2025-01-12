<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>


        <?php 
            if(isset($_GET['cat_id'])){
                $category_id = $_GET['cat_id'];
                $posts = $con->prepare("SELECT posts.id as id, posts.title as title, posts.subtitle as subtitle,
                users.username as username, posts.created_at as created_at, posts.category_id as category_id FROM posts
                JOIN categories 
                ON posts.category_id = categories.category_id
                JOIN users 
                ON users.id = posts.user_id
                WHERE categories.category_id = '$category_id'");
            
                $posts->execute();
                $rows = $posts->fetchAll(PDO::FETCH_OBJ);
                $categories = $con->prepare("SELECT * FROM categories");
                $categories->execute();
                $category = $categories->fetchAll(PDO::FETCH_OBJ);
            }
            else {
              header("location:../404.php");
            }

            
            


        ?>

        <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">

        <?php foreach($rows as $row) : ?> 
          <!-- Post preview-->
          <div class="post-preview">
          <a href="http://localhost/clean-blog/posts/post.php?post_id=<?php echo $row->id; ?>">
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
          <a href="http://localhost/clean-blog/categories/category.php?cat_id=<?php echo $cat->category_id; ?>"> 
            <div class="alert alert-dark bg-dark text-center text-white" role="alert">
              <?php echo $cat->name; ?>
            </div>
            </a>
          </div>
        <?php endforeach; ?>
        </div>


<?php require "../includes/footer.php"; ?>