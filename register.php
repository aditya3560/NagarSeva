<?php
include "db.php";

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "INSERT INTO users (name,email,password) 
              VALUES ('$name','$email','$password')";

    if(mysqli_query($conn,$query)){
        echo "<script>alert('Registration Successful'); window.location='login.php';</script>";
    }else{
        echo "<script>alert('Email already exists');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Register</title>
  <link rel="stylesheet" href="/NagarSeva/assets/style.css?v=1">
</head>
<body>

<?php include "partials/nav.php"; ?>

<div class="container form-wrap">
  <h2 class="form-title">User Registration</h2>

  <form method="POST" class="form">
    <label>Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <br><br>
    <button type="submit" name="register" class="btn btn-primary">Register</button>
  </form>
</div>

</body>
</html>