<?php
include "db.php";
$today = date('Y-m-d');

$query = "SELECT * FROM attendance WHERE Date = '$today' ORDER BY Time DESC";
$res = mysqli_query($conn, $query);

if(mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_assoc($res)) {
        echo "<tr>";
        echo "<td>" . $row['AttendanceID'] . "</td>";
        echo "<td>" . $row['MemberID'] . "</td>";
        echo "<td>" . $row['Date'] . "</td>";
        echo "<td>" . $row['Time'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>आज अजून कोणीही हजेरी लावलेली नाही.</td></tr>";
}
?>