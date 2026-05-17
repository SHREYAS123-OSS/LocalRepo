<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // आधी चेक करा की हा ईमेल आधीच वापरला आहे का
    $check = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
    
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('हा ईमेल आधीच रजिस्टर आहे!'); window.location.href='../public/signup.php';</script>";
    } else {
        $sql = "INSERT INTO admins (username, email, password) VALUES ('$user', '$email', '$pass')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('अकाऊंट यशस्वीपणे तयार झाले! आता लॉगिन करा.'); window.location.href='../public/login.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>