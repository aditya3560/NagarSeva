<?php
session_start();
include "db.php";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $q = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $res = mysqli_query($conn,$q);

    if(mysqli_num_rows($res)==1){
        $row = mysqli_fetch_assoc($res);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        header("Location: user/dashboard.php");
        exit();
    }else{
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Login</title>
  <link rel="stylesheet" href="/NagarSeva/assets/style.css?v=1">
</head>
<body>

<?php include "partials/nav.php"; ?>

<div class="container form-wrap">
  <h2 class="form-title">User Login</h2>

  <form method="POST" class="form">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <br><br>
    <button type="submit" name="login" class="btn btn-primary">Login</button>
    <a href="register.php" class="btn btn-outline">Create Account</a>
  </form>
</div>

</body>
</html>