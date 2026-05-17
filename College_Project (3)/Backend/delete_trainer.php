<?php
include "db.php";
if(isset($_GET['id'])){
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM trainers WHERE TrainerID = $id");
    header("Location: ../admin/trainers.php");
}
?>