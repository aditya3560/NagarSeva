<?php
session_start();
include("../db.php");

if(!isset($_SESSION['admin'])){
  header("Location: /NagarSeva/admin/login.php");
  exit();
}

if(isset($_GET['logout'])){
  session_destroy();
  header("Location: /NagarSeva/admin/login.php");
  exit();
}

$msg = "";

// Update status + remark
if(isset($_POST['update'])){
  $id = (int)$_POST['id'];
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $remark = mysqli_real_escape_string($conn, $_POST['remark']);
  mysqli_query($conn, "UPDATE complaints SET status='$status', admin_remark='$remark' WHERE id=$id");
  $msg = "Complaint #$id updated successfully!";
}

// Stats
$total  = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM complaints"))['c'];
$pending = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM complaints WHERE status='Pending'"))['c'];
$inprog  = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM complaints WHERE status='In Progress'"))['c'];
$done    = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM complaints WHERE status='Completed'"))['c'];

// Filter
$where = "1";
if(isset($_GET['status']) && $_GET['status']!=""){
  $st = mysqli_real_escape_string($conn, $_GET['status']);
  $where = "complaints.status='$st'";
}

// List
$res = mysqli_query($conn, "SELECT complaints.*, users.name FROM complaints
JOIN users ON complaints.user_id = users.id
WHERE $where
ORDER BY complaints.id DESC");

function badge($s){
  if($s=="Pending") return "badge b-pending";
  if($s=="In Progress") return "badge b-progress";
  return "badge b-done";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - NagarSeva</title>
  <link rel="stylesheet" href="/NagarSeva/assets/style.css?v=2">
</head>
<body>

<div class="nav">
  <div class="container">
    <div class="row">
      <div class="brand">🛠 NagarSeva Admin</div>
      <div class="nav-links">
        <a href="/NagarSeva/index.php">Home</a>
        <a href="/NagarSeva/admin/dashboard.php">Dashboard</a>
        <a href="/NagarSeva/admin/dashboard.php?logout=1">Logout</a>
      </div>
    </div>
  </div>
</div>

<div class="container" style="margin-top:18px;">

  <div class="card">
    <h2 style="margin:0">Admin Dashboard</h2>
    <p style="color:#6b7280;margin:6px 0 0">Manage complaints, view photos and update status.</p>

    <?php if($msg!=""){ ?>
      <div class="card" style="margin-top:12px;border-left:6px solid #16a34a;">
        <b style="color:#16a34a;"><?php echo $msg; ?></b>
      </div>
    <?php } ?>

    <div class="stats">
      <div class="stat-card"><div class="stat-title">Total</div><div class="stat-value"><?php echo $total; ?></div></div>
      <div class="stat-card"><div class="stat-title">Pending</div><div class="stat-value"><?php echo $pending; ?></div></div>
      <div class="stat-card"><div class="stat-title">In Progress</div><div class="stat-value"><?php echo $inprog; ?></div></div>
      <div class="stat-card"><div class="stat-title">Completed</div><div class="stat-value"><?php echo $done; ?></div></div>
    </div>
  </div>

  <div class="card" style="margin-top:14px;">
    <form method="GET" style="display:flex; gap:10px; align-items:end; flex-wrap:wrap;">
      <div style="min-width:220px;">
        <label style="font-weight:700;color:#374151;">Filter by Status</label>
        <select name="status">
          <option value="">All</option>
          <option value="Pending">Pending</option>
          <option value="In Progress">In Progress</option>
          <option value="Completed">Completed</option>
        </select>
      </div>
      <button class="btn btn-primary">Apply Filter</button>
      <a class="btn btn-outline" href="/NagarSeva/admin/dashboard.php">Reset</a>
    </form>
  </div>

  <div class="table-wrap" style="margin-top:14px;">
    <table>
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>Category</th>
        <th>Location</th>
        <th>Description</th>
        <th>Photo</th>
        <th>Status</th>
        <th>Admin Remark</th>
        <th>Update</th>
      </tr>

      <?php while($row=mysqli_fetch_assoc($res)){ ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['category']); ?></td>
        <td><?php echo htmlspecialchars($row['location']); ?></td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>

        <td>
          <?php if(!empty($row['photo'])){ ?>
            <a class="btn btn-outline" target="_blank" href="/NagarSeva/uploads/<?php echo $row['photo']; ?>">View</a>
          <?php } else { ?>
            <span style="color:#6b7280;">No Photo</span>
          <?php } ?>
        </td>

        <td><span class="<?php echo badge($row['status']); ?>"><?php echo $row['status']; ?></span></td>
        <td><?php echo htmlspecialchars($row['admin_remark']); ?></td>

        <td>
          <form method="POST" style="display:flex; gap:8px; flex-wrap:wrap;">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <select name="status" required style="min-width:140px;">
              <option <?php if($row['status']=="Pending") echo "selected"; ?>>Pending</option>
              <option <?php if($row['status']=="In Progress") echo "selected"; ?>>In Progress</option>
              <option <?php if($row['status']=="Completed") echo "selected"; ?>>Completed</option>
            </select>
            <input type="text" name="remark" placeholder="Remark" value="<?php echo htmlspecialchars($row['admin_remark']); ?>" style="min-width:180px;">
            <button class="btn btn-primary" name="update">Update</button>
          </form>
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>

</div>

</body>
</html>