<?php
$conn = mysqli_connect("localhost", "root", "", "smart_gym");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
?>