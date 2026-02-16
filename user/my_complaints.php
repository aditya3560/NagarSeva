<?php
session_start();
include("../db.php");

if(!isset($_SESSION['user_id'])){
  header("Location: ../login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM complaints WHERE user_id='$user_id' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Complaints</title>
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
        <a class="active" href="my_complaints.php">My Complaints</a>
        <a href="../logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="hero">
    <h1>My Complaints</h1>
    <p>Your submitted complaints and their status.</p>
  </div>

  <div class="card" style="margin-top:16px;">
    <table width="100%" cellpadding="10" cellspacing="0">
      <tr style="font-weight:700;">
        <td>ID</td>
        <td>Category</td>
        <td>Location</td>
        <td>Status</td>
        <td>Photo</td>
      </tr>

      <?php while($row = mysqli_fetch_assoc($res)){ ?>
      <tr style="border-top:1px solid #eee;">
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['category']); ?></td>
        <td><?php echo htmlspecialchars($row['location']); ?></td>
        <td><?php echo $row['status']; ?></td>
        <td>
          <td>
  <?php 
  if($row['photo'] != ""){
      echo "<a target='_blank' href='/NagarSeva/uploads/".$row['photo']."'>View Photo</a>";
  } else {
      echo "<span style='color:red;font-weight:bold;'>Please upload photo</span>";
  }
  ?>
</td>
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>

</body>
</html>