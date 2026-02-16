<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
  <link rel="stylesheet" href="/NagarSeva/assets/style.css?v=1">
</head>
<body>

<div class="nav">
  <div class="container">
    <div class="row">
      <div class="brand">🚦 NagarSeva Online</div>
      <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="raise_complaint.php">Raise Complaint</a>
        <a href="my_complaints.php">My Complaints</a>
        <a href="../logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="hero">
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h1>
    <p>From here you can raise a new complaint and track complaint status.</p>
    <div class="top-actions">
      <a class="btn btn-dark" href="raise_complaint.php">Raise Complaint</a>
      <a class="btn btn-outline" href="my_complaints.php">My Complaints</a>
    </div>
  </div>
</div>

</body>
</html>