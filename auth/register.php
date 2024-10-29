<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php 
$error_message = '';

if (isset($_POST['submit'])) {
  if (empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password'])) {
      $error_message = "Please fill in all fields";
  } else {
      $email = $_POST['email'];
      $username = $_POST['username'];
      $password = $_POST['password'];

      $insert = $con->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
      $insert->execute([
        ":email" => $email,
        ":username" => $username,
        ":password" => password_hash($password, PASSWORD_DEFAULT),
      ]);

      header("location: login.php");
      exit;
  }
}
?>

<?php if ($error_message): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
<?php endif; ?>

<form method="POST" action="register.php">
  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
  </div>

  <div class="form-outline mb-4">
    <input type="text" name="username" id="form2Example1" class="form-control" placeholder="Username" />
  </div>

  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
  </div>

  <!-- Submit button -->
  <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Register</button>

  <!-- Register buttons -->
  <div class="text-center">
    <p>Already a member? <a href="login.php">Login</a></p>
  </div>
</form>

<?php require "../includes/footer.php"; ?>