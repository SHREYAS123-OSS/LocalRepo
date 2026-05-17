<?php include "../Backend/db.php"; ?>
<!DOCTYPE html>
<?php include "../Backend/db.php"; ?>
<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <title>Smart Gym - QR Scanner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode"></script>
    
    <style>
        /* Sidebar & Layout Styles - Dashboard sarakhech */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #ff3c00;
            --primary-dark: #cc3000;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-primary: #0a0a0a;
            --bg-secondary: #111111;
            --bg-card: #1a1a1a;
            --text-primary: #ffffff;
            --text-secondary: #aaaaaa;
            --text-muted: #666666;
            --border: #222222;
            --border-light: #2a2a2a;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            --transition: all 0.2s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.5;
            display: flex;
        }

        /* Sidebar - Matching payments page style */
        .sidebar {
            width: 240px;
            background: var(--bg-secondary);
            height: 100vh;
            padding: 2rem 1.5rem;
            border-right: 1px solid var(--border);
            position: fixed;
        }

        .sidebar h2 {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: var(--text-primary);
            margin-bottom: 2.5rem;
            position: relative;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }

        .sidebar h2 i {
            color: var(--primary);
            margin-right: 0.5rem;
        }

        .sidebar a {
            display: block;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 0.75rem 0;
            font-size: 0.95rem;
            font-weight: 400;
            transition: var(--transition);
            border-bottom: 1px solid var(--border);
        }

        .sidebar a:hover,
        .sidebar a.active {
            color: var(--primary);
        }

        .logout-btn {
            margin-top: 2rem;
            color: var(--text-muted) !important;
            border-bottom: none !important;
        }

        .logout-btn:hover {
            color: var(--danger) !important;
        }

        /* Main Content */
        .main-content {
            margin-left: 240px;
            padding: 2.5rem 3rem;
            width: calc(100% - 240px);
            min-height: 100vh;
        }

        .qr-container { text-align: center; color: white; }
        #reader { width: 100%; max-width: 500px; margin: auto; background: #333; border-radius: 15px; overflow: hidden; border: 1px solid var(--border); }
        .attendance-log { margin-top: 30px; background: #1c1c1c; padding: 15px; border-radius: 10px; border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; color: white; }
        th, td { border: 1px solid #444; padding: 12px; text-align: center; }
        th { background: var(--primary); }
        #result-status { margin-top: 15px; font-weight: bold; padding: 10px; border-radius: 5px; display: none; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class="fas fa-dumbbell"></i> SMART GYM</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="members.php">Members</a>
    <a href="qr.php" class="active">Attendance</a>
    <a href="payments.php">Payments</a>
    <a href="reports.php">Reports</a>
    <a href="trainers.php">Trainers</a>
    <a href="../public/login.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
</div>

<div class="main-content">
    <a href="javascript:history.back()" style="border-bottom: 1px solid var(--border); color: var(--text-secondary); text-decoration:none;">
        <i class="fas fa-arrow-left" style="margin-right: 10px; font-size: 0.8rem; color: var(--primary);"></i> Back
    </a>
    <div class="qr-container">
        <h1><span style="color: #ff3c00;">SMART</span> GYM SCANNER</h1>
        <p style="color: var(--text-secondary); margin-bottom: 20px;">कृपया तुमचा QR कोड कॅमेरासमोर धरा</p>

        <div id="reader"></div>

        <div id="result-status"></div>

        <div class="attendance-log">
            <h2>आजची हजेरी (Live)</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Member ID</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// JS Logic (Same as your original code)
function loadAttendance() {
    fetch('../Backend/get_today_attendance.php')
    .then(res => res.text())
    .then(data => {
        document.getElementById('table-body').innerHTML = data;
    });
}

function onScanSuccess(decodedText, decodedResult) {
    html5QrcodeScanner.clear(); 
    let statusDiv = document.getElementById('result-status');
    statusDiv.style.display = "block";
    statusDiv.style.backgroundColor = "#ff3c00";
    statusDiv.innerHTML = "प्रक्रिया सुरू आहे... ID: " + decodedText;

    let formData = new FormData();
    formData.append('member_id', decodedText);

    fetch('../Backend/save-attendance.php', {
        method: 'POST',
        body: new URLSearchParams(formData)
    })
    .then(response => response.text())
    .then(data => {
        statusDiv.innerHTML = data;
        statusDiv.style.backgroundColor = "#28a745"; 
        setTimeout(() => {
            statusDiv.style.display = "none";
            location.reload();
        }, 3000);
    })
    .catch(err => {
        alert("Server Error!");
        location.reload();
    });
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", 
    { 
        fps: 30, 
        qrbox: { width: 400, height: 400 },
        aspectRatio: 1.0,
        showTorchButtonIfSupported: true,
        experimentalFeatures: { useBarCodeDetectorIfSupported: true }
    }
);

html5QrcodeScanner.render(onScanSuccess);
loadAttendance();
</script>

</body>
</html>