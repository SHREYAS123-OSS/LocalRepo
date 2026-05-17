<?php
include "db.php";

$name = $_POST['name'];
$email = $_POST['mobile'];
$plan = $_POST['plan'];

$sql = "INSERT INTO members(name,mobile,plan,fees_status)
VALUES('$name','$mobile','$plan','Pending')";

mysqli_query($conn,$sql);

header("Location: ../admin/members.php");
?>
