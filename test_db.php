<?php
include "db.php";
echo "DB Connected OK<br>";

$res = mysqli_query($conn, "SELECT COUNT(*) AS c FROM users");
if(!$res){
  die("Query Error: ".mysqli_error($conn));
}
$row = mysqli_fetch_assoc($res);
echo "Total users = ".$row['c'];
?>