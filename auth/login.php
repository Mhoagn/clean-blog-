<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
    $error_message = '';
    if(isset($_POST['submit'])) {
        if(empty($_POST['email']) || empty($_POST['password'])) {
            $error_message = "Email and password are required";
        }
        else {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $login = $con->prepare("SELECT * FROM users WHERE email = :email");
            $login->execute([':email' => $email]);

            $row = $login->fetch(PDO::FETCH_ASSOC);
            if($login->rowCount() == 0) {
                $error_message = "Email is incorrect";
            }
            else { 
                 if(password_verify($password, $row['password'])){
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['id'] = $row['id']; // this is user_id

                    header('location: ../index.php');
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

<form method="POST" action="login.php">
    <!-- Email input -->
    <div class="form-outline mb-4">
        <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
    </div>

    <!-- Password input -->
    <div class="form-outline mb-4">
        <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
    </div>

    <!-- Submit button -->
    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Login</button>

    <!-- Register buttons -->
    <div class="text-center">
        <p>Not a member? <a href="register.php">Register</a></p>
    </div>
</form>

<?php require "../includes/footer.php"; ?>