<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 
  $error_message = '';
  if(isset($_POST['submit'])) {
      if(empty($_POST['email']) || empty($_POST['password'])) {
          $error_message = "Email and password are required";
      }
      else {
          $email = $_POST['email'];
          $password = $_POST['password'];

          $login = $con->prepare("SELECT * FROM admins WHERE email = :email");
          $login->execute([':email' => $email]);

          $row = $login->fetch(PDO::FETCH_ASSOC);
          if($login->rowCount() == 0) {
              $error_message = "Email is incorrect";
          }
          else { 
               if(password_verify($password, $row['password'])){
                  $_SESSION['admin_name'] = $row['admin_name'];
                  $_SESSION['admin_id'] = $row['id']; // this is admin_id

                  header('location: ../index_admin.php');
                  exit;
               }
               else {
                  $error_message = "Password is incorrect";
               }
          }
      }
  }
?>

<?php if ($error_message): ?>
  <div class="alert alert-danger text-center" role="alert">
      <?php echo htmlspecialchars($error_message); ?>
  </div>
<?php endif; ?>


      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mt-5">Login</h5>
              <form method="POST" class="p-auto" action="login-admins.php">
                  <!-- Email input -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
                   
                  </div>

                  
                  <!-- Password input -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
                    
                  </div>



                  <!-- Submit button -->
                  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>

                 
                </form>

            </div>
       </div>
     </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>