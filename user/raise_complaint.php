<?php
session_start();
include("../db.php");

if(!isset($_SESSION['user_id'])){
  header("Location: ../login.php");
  exit();
}

$msg = "";

if(isset($_POST['submit'])){
  $user_id = $_SESSION['user_id'];
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);

  // ✅ PHOTO IS COMPULSORY
  if(!isset($_FILES['photo']) || $_FILES['photo']['name'] == ""){
    $msg = "Please upload a photo before submitting complaint!";
  } else {

    // upload photo
    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
    $allow = ["jpg","jpeg","png","webp"];

    if(!in_array($ext, $allow)){
      $msg = "Only JPG, JPEG, PNG, WEBP files are allowed!";
    } else {

      // create uploads folder if not exists
      if(!is_dir("../uploads")) {
        mkdir("../uploads", 0777, true);
      }

      $photoName = "cmp_" . time() . "_" . rand(100,999) . "." . $ext;
      $target = "../uploads/" . $photoName;

      if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)){

        $q = "INSERT INTO complaints (user_id, category, location, description, photo, status)
              VALUES ('$user_id','$category','$location','$description','$photoName','Pending')";

        if(mysqli_query($conn, $q)){
          echo "<script>alert('Complaint Submitted Successfully'); window.location='my_complaints.php';</script>";
          exit();
        } else {
          $msg = "DB Error: " . mysqli_error($conn);
        }

      } else {
        $msg = "Photo upload failed. Try again!";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Raise Complaint</title>
  <link rel="stylesheet" href="/NagarSeva/assets/style.css?v=1">
</head>
<body>

<div class="nav">
  <div class="container">
    <div class="row">
      <div class="brand">🚦 NagarSeva Online</div>
      <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a class="active" href="raise_complaint.php">Raise Complaint</a>
        <a href="my_complaints.php">My Complaints</a>
        <a href="../logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>

<div class="container form-wrap">
  <h2 class="form-title">Raise a Complaint</h2>

  <?php if($msg!=""){ ?>
    <div class="card" style="border-left:5px solid #e11; margin-bottom:12px;">
      <b style="color:#e11;"><?php echo $msg; ?></b>
    </div>
  <?php } ?>

  <!-- ✅ enctype required for file upload -->
  <form method="POST" enctype="multipart/form-data" class="form">
    
    <label>Category</label>
    <input type="text" name="category" placeholder="Garbage / Pothole / Street Light..." required>

    <label>Location</label>
    <input type="text" name="location" placeholder="Area, Landmark, Ward..." required>

    <label>Description</label>
    <textarea name="description" rows="4" placeholder="Explain the issue in detail..." required></textarea>

    <label>Upload Photo (Required)</label>
    <!-- ✅ required makes photo compulsory -->
    <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp" required>

    <br><br>
    <button type="submit" name="submit" class="btn btn-primary">Submit Complaint</button>
    <a class="btn btn-outline" href="dashboard.php">Back</a>
  </form>
</div>

</body>
</html>