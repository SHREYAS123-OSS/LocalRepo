<?php
include "db.php";

// URL मधून 'id' मिळवण्यासाठी
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // डेटाबेसमधून मेंबर डिलीट करण्याची क्वेरी
    $sql = "DELETE FROM members WHERE id = $id";

    if(mysqli_query($conn, $sql)){
        // डिलीट झाल्यावर पुन्हा मेंबर्स पेजवर जाण्यासाठी
        header("Location: ../admin/members.php?msg=DeletedSuccessfully");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header("Location: ../admin/members.php");
}
?>