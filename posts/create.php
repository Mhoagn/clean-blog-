<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

if (!isset($_SESSION['username'])) {
  header('Location: http://localhost/clean-blog/auth/login.php');
  exit(); 
}

  $categories = $con->prepare("SELECT * FROM categories");
  $categories->execute();
  $category = $categories->fetchAll(PDO::FETCH_OBJ);

  if(isset($_POST['submit'])) {
    if(empty($_POST['title']) || empty($_POST['subtitle']) || empty($_POST['body']) || empty($_POST['category_id'])){
      echo "One or more inputs are empty";
    }
    else {
      $title = $_POST['title'];
      $subtitle = $_POST['subtitle'];
      $body = $_POST['body'];
      $category_id = $_POST['category_id'];
      $img = $_FILES['image']['name'];
      $user_id = $_SESSION['id'];
    
      $dir = "images/" . basename($img);
      $insert = $con->prepare("INSERT INTO posts (title, subtitle, content, category_id, img,user_id)
      VALUES (:title, :subtitle, :content, :category_id, :img, :user_id)");

      $insert->execute([
        ':title' => $title,
        ':subtitle' => $subtitle, 
        ':content' => $body,
        ':category_id' => $category_id,
        ':img' => $img,
        ':user_id' => $user_id
      ]);

      if(move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
        header('location: http://localhost/clean-blog/index.php');
      }
    }
  }

?>


            <form method="POST" action="create.php" enctype="multipart/form-data">
              <!-- Title input -->
              <div class="form-outline mb-4">
                <input type="text" name="title" id="form2Example1" class="form-control" placeholder="title" />
               
              </div>

              <div class="form-outline mb-4">
                <input type="text" name="subtitle" id="form2Example1" class="form-control" placeholder="subtitle" />
            </div>

              <div class="form-outline mb-4">
                <textarea type="text" name="body" id="form2Example1" class="form-control" placeholder="body" rows="8"></textarea>
            </div>

            <div class="form-outline mb-4">
            <select name="category_id" class="form-select" aria-label="Default select example" place>
              <option disabled selected>Open this categories menu</option>
              <?php foreach($category as $cat) : ?>
                <option value="<?php echo $cat->category_id; ?>"><?php echo $cat->name; ?></option>
              <?php endforeach; ?>  
            </select>  
            </div>

             <div class="form-outline mb-4">
                <input type="file" name="image" id="form2Example1" class="form-control" placeholder="image" />
            </div>
                

              <!-- Submit button -->
              <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
            </form>


           
<?php require "../includes/footer.php"; ?>