<?php
$conn = mysqli_connect("localhost","root","","nagar_seva");

if(!$conn){
    die("DB Connection Failed: ".mysqli_connect_error());
}
?>