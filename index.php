
<html>
<head>
  <title>NagarSeva Online</title>
  <link rel="stylesheet" href="/NagarSeva/assets/style.css?v=1">
</head>
<body>
  <?php include "partials/nav.php"; ?>

  <div class="container">
    <div class="hero">
      <h1>Smart City Complaint Management System</h1>
      <p>Report civic issues like garbage, potholes, street lights and water problems. Track complaint status transparently. Admin updates progress.</p>
      <div class="top-actions">
        <a class="btn btn-dark" href="register.php">Get Started</a>
        <a class="btn btn-outline" href="login.php">User Login</a>
      </div>
    </div>

    <div class="grid">
      <div class="card">
        <h3>📝 Raise Complaint</h3>
        <p>Submit issue category, location, description and optional photo.</p>
        <a class="btn btn-primary" href="login.php">Raise Now</a>
      </div>

      <div class="card">
        <h3>📌 Track Status</h3>
        <p>View complaint status: Pending, In Progress, Completed.</p>
        <a class="btn btn-primary" href="login.php">Track</a>
      </div>

      <div class="card">
        <h3>🛠 Admin Panel</h3>
        <p>Admin can view complaints, update status and add remarks.</p>
        <a class="btn btn-primary" href="admin/login.php">Admin Login</a>
      </div>
    </div>

    <div class="footer">© <?php echo date("Y"); ?> NagarSeva Online • Diploma Project</div>
  </div>
</body>
</html>