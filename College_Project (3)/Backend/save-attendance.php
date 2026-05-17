<?php
include "db.php"; // खात्री कर की db.php याच फोल्डरमध्ये आहे

if (isset($_POST['member_id'])) {
    // मिळालेला ID सुरक्षित करणे
    $member_id = mysqli_real_escape_string($conn, $_POST['member_id']);
    
    // आजची तारीख आणि वेळ सेट करणे
    $today = date('Y-m-d');
    $time = date('H:i:s');

    // १. आधी तपासा की हा मेंबर ID खरंच अस्तित्वात आहे का?
    $user_check = mysqli_query($conn, "SELECT id FROM members WHERE id = '$member_id'");
    
    if (mysqli_num_rows($user_check) == 0) {
        echo "चूक: हा मेंबर आयडी अस्तित्वात नाही!";
    } else {
        // २. आजची हजेरी आधीच लावली आहे का ते तपासा
        $check = mysqli_query($conn, "SELECT * FROM attendance WHERE MemberID = '$member_id' AND Date = '$today'");

        if (mysqli_num_rows($check) > 0) {
            echo "तुमची आजची हजेरी आधीच लागली आहे!";
        } else {
            // ३. नवीन हजेरी इन्सर्ट करा (तुझ्या SQL स्ट्रक्चरनुसार)
            $sql = "INSERT INTO attendance (MemberID, Date, Time) VALUES ('$member_id', '$today', '$time')";
            if (mysqli_query($conn, $sql)) {
                echo "हजेरी यशस्वीपणे नोंदवली गेली! वेळ: $time";
            } else {
                echo "डेटाबेस एरर: " . mysqli_error($conn);
            }
        }
    }
} else {
    echo "थेट प्रवेश निषिद्ध आहे!";
}
?>