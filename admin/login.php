<?php
session_start();
include("../db.php");

$error = "";

if(isset($_POST['login'])){

    $username = trim($_POST['username'] ?? "");
    $password = trim($_POST['password'] ?? "");

    // 1) Empty validation
    if($username=="" || $password==""){
        $error = "Please enter username and password.";
    } 
    else {
        // 2) Fixed admin credentials (simple & best for diploma)
        // Change these to your own:
        $ADMIN_USER = "Sanjivani";
        $ADMIN_PASS = "Student";

        if($username === $ADMIN_USER && $password === $ADMIN_PASS){
            $_SESSION['admin'] = $ADMIN_USER;
            header("Location: /NagarSeva/admin/dashboard.php");
            exit();
        } else {
            $error = "Wrong username or password!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login - NagarSeva</title>
  <link rel="stylesheet" href="/NagarSeva/assets/style.css?v=2">
</head>
<body>

<div class="nav">
  <div class="container">
    <div class="row">
      <div class="brand">🛠 NagarSeva Admin</div>
      <div class="nav-links">
        <a href="/NagarSeva/index.php">Home</a>
        <a href="/NagarSeva/admin/login.php">Admin Login</a>
      </div>
    </div>
  </div>
</div>

<div class="container" style="margin-top:22px;max-width:520px;">
  <div class="card">
    <h2 style="margin:0">Admin Login</h2>
    <p style="color:#6b7280;margin-top:6px">Enter admin credentials to access dashboard.</p>

    <?php if($error!=""){ ?>
      <div class="card" style="margin-top:12px;border-left:6px solid #dc2626;">
        <b style="color:#dc2626;"><?php echo $error; ?></b>
      </div>
    <?php } ?>

    <form method="POST" style="margin-top:14px;">
      <label style="font-weight:700;color:#374151;">Username</label>
      <input type="text" name="username" placeholder="Enter username">

      <div style="height:10px;"></div>

      <label style="font-weight:700;color:#374151;">Password</label>
      <input type="password" name="password" placeholder="Enter password">

      <div style="height:14px;"></div>

      <button class="btn btn-primary" name="login" style="width:100%;">Login</button>

      <p style="margin-top:10px;color:#6b7280;font-size:13px;">
        
      </p>
    </form>
  </div>
</div>

</body>
</html>