<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $spec = mysqli_real_escape_string($conn, $_POST['specialization']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO trainers (Name, Specialization, password) VALUES ('$name', '$spec', '$pass')";

    if (mysqli_query($conn, $sql)) {
        // यशस्वी झाल्यावर पुन्हा 'trainers.php' वर पाठवा
        header("Location: ../admin/trainers.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>