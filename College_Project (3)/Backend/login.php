<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $role = $_POST['role'];

    if ($role == 'admin') {
        $query = "SELECT * FROM admins WHERE (username='$user_input' OR email='$user_input') AND password='$pass'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = 'admin';
            $_SESSION['user'] = $user_input;
            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            header("Location: ../public/login.php?error=Invalid email/username or password");
            exit();
        }
    } else if ($role == 'trainer') {
        $query = "SELECT * FROM trainers WHERE Name='$user_input' AND password='$pass'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = 'trainer';
            $_SESSION['user'] = $user_input;
            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            header("Location: ../public/login.php?error=Invalid trainer name or password");
            exit();
        }
    }
} else {
    header("Location: ../public/login.php");
    exit();
}
?>