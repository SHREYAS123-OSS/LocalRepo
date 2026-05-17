<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // यामुळे नक्की काय एरर आहे ते स्क्रीनवर दिसेल ब्रो!

include "db.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "UPDATE members SET fees_status='Paid' WHERE id=$id";

    if(mysqli_query($conn, $sql)){
        header("Location: ../admin/payments.php?status=success");
        exit();
    } else {
        echo "Query Failed: " . mysqli_error($conn);
    }
} else {
    echo "ID सापडला नाही ब्रो!";
}

exit();
?>