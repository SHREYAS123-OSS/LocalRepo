<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_password']);

    // ईमेल अस्तित्वात आहे का ते तपासा
    $check = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        $update = "UPDATE admins SET password='$new_pass' WHERE email='$email'";
        if (mysqli_query($conn, $update)) {
            echo "<script>alert('पासवर्ड यशस्वीपणे बदलला आहे!'); window.location.href='../public/login.php';</script>";
        }
    } else {
        echo "<script>alert('हा ईमेल आमच्या रेकॉर्डमध्ये नाही!'); window.location.href='../public/forgot_password.php';</script>";
    }
}
?>