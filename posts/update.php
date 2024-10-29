<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>


<?php 
if (!isset($_SESSION['username'])) {
  header('Location: http://localhost/clean-blog/auth/login.php');
  exit(); 
}

if(isset($_GET['update_id'])) {
  $update_id = filter_var($_GET['update_id'], FILTER_SANITIZE_NUMBER_INT);

  $select = $con->prepare("SELECT * FROM posts WHERE id = :id");
  $select->execute([':id' => $update_id]);
  $rows = $select->fetch(PDO::FETCH_OBJ); 

  // Kiểm tra quyền chỉnh sửa
  if($rows->user_id != $_SESSION['id']) {
      die("Bạn không có quyền chỉnh sửa bài viết này!");
  }

  if(isset($_POST['submit'])){
      if(empty($_POST['title']) || empty($_POST['subtitle']) || empty($_POST['body'])){
          $error = "Một hoặc nhiều trường dữ liệu còn trống";
      } else {
          $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
          $subtitle = filter_var($_POST['subtitle'], FILTER_SANITIZE_STRING);
          $body = filter_var($_POST['body'], FILTER_SANITIZE_STRING);
          $user_id = $_SESSION['id'];

          

  if(!empty($_FILES['image']['name'])) {
    $img = $_FILES['image']['name'];
    $img_ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    
    if(!in_array($img_ext, $allowed_ext)) {
        $error = "Chỉ cho phép upload file ảnh (jpg, jpeg, png, gif)";
    } else {
        $img_name = uniqid() . '.' . $img_ext;
        $dir = "images/" . $img_name;
        
        if(move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
            // Xóa ảnh cũ nếu có
            if(!empty($rows->img) && file_exists("images/" . $rows->img)) {
                unlink("images/" . $rows->img);
            }
        } else {
            $error = "Có lỗi xảy ra khi upload ảnh";
        }
    }
  } else {
    $img_name = $rows->img; // Giữ nguyên ảnh cũ nếu không upload ảnh mới
  }


        if(!isset($error)) {
          $update = $con->prepare("UPDATE posts SET 
              title = :title, 
              subtitle = :subtitle,
              content = :content,
              img = :img,
              user_id = :user_id
              WHERE id = :id");

          $update->execute([
              ':title' => $title,
              ':subtitle' => $subtitle,
              ':content' => $body,
              ':img' => $img_name,
              ':user_id' => $user_id,
              ':id' => $update_id
          ]);

          if($update->rowCount()) {
              $success = "Bài viết đã được cập nhật thành công";
              header('location: ../index.php');
              exit();
          } else {
              $error = "Không có thay đổi nào được thực hiện";
          }
      }
  }
}
} else {
die("Không tìm thấy bài viết cần cập nhật");
}

?>
        
       
                <!-- Main Content-->
        <div class="container px-4 px-lg-5">
            <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

            <form method="POST" action="update.php?update_id=<?php echo $rows->id; ?>" enctype="multipart/form-data">
              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="text" name="title" value="<?php echo $rows->title; ?>" id="form2Example1" class="form-control" placeholder="title" />
               
              </div>

              <div class="form-outline mb-4">
                <input type="text" name="subtitle" value="<?php echo $rows->subtitle; ?>" id="form2Example1" class="form-control" placeholder="subtitle" />
            </div>

              <div class="form-outline mb-4">
                <textarea type="text" name="body"  id="form2Example1" class="form-control" placeholder="body" rows="8"><?php echo $rows->content; ?></textarea>
            </div>

              
             <div class="form-outline mb-4">
                <input type="file" name="image" id="form2Example1" class="form-control" placeholder="image" />
            </div>


              <!-- Submit button -->
              <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Update</button>

          
            </form>


           
        <?php require "../includes/footer.php"; ?>