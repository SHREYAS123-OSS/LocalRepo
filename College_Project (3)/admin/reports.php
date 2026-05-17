<?php 
include "../Backend/db.php"; 

// १. गेल्या ७ दिवसांचा डेटाबेस मधून डेटा मिळवणे
$attendance_data = [];
$days = [];

// गेल्या ७ दिवसांची तारीख आणि काउंट मिळवण्यासाठी query
$query = "SELECT DATE(Date) as scan_date, COUNT(*) as count 
          FROM attendance 
          GROUP BY DATE(Date) 
          ORDER BY DATE(Date) ASC 
          LIMIT 7";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Date format badlun 'Mon', 'Tue' karne
        $days[] = date('D', strtotime($row['scan_date']));
        $attendance_data[] = (int)$row['count'];
    }
} else {
    // जर डेटा नसेल तर रिकामे ग्राफ दिसू नये म्हणून
    $attendance_data = [0, 0, 0, 0, 0, 0, 0];
    $days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
}

// २. Summary Statistics (Real-time calculations)
$total_present = array_sum($attendance_data);
$avg_attendance = count($attendance_data) > 0 ? round($total_present / count($attendance_data), 1) : 0;

// Peak Day काढणे
$peak_index = array_search(max($attendance_data), $attendance_data);
$peak_day = ($total_present > 0) ? $days[$peak_index] : "N/A";

$chartLabels = json_encode($days);
$chartValues = json_encode($attendance_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports · SMART GYM</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        /* Sidebar - Exact match with members page */
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

        h1 {
            font-size: 2rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 2rem;
            letter-spacing: -0.02em;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: var(--bg-secondary);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            transition: var(--transition);
        }

        .stat-card:hover {
            border-color: var(--border-light);
        }

        .stat-card h3 {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: var(--text-muted);
            font-weight: 400;
            margin-bottom: 0.5rem;
        }

        .stat-card .number {
            font-size: 2rem;
            font-weight: 400;
            color: var(--text-primary);
        }

        /* Chart Container */
        .chart-container {
            background: var(--bg-secondary);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            margin-bottom: 2.5rem;
        }

        .chart-container h2 {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        /* Table */
        .table-box {
            background: var(--bg-secondary);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .table-box h3 {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 1rem 0.5rem 0.5rem 0.5rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 0.75rem 0.5rem;
            font-size: 0.95rem;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border);
        }

        td:last-child {
            color: var(--success);
        }

        tr:hover td {
            background: var(--bg-card);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-muted);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; border-right: none; }
            .main-content { margin-left: 0; width: 100%; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class="fas fa-dumbbell"></i> SMART GYM</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="members.php">Members</a>
    <a href="qr.php">Attendance</a>
    <a href="payments.php">Payments</a>
    <a href="reports.php" class="active">Reports</a>
    <a href="trainers.php">Trainers</a>
    <a href="../public/login.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
</div>

<div class="main-content">
    <a href="javascript:history.back()" style="border-bottom: 1px solid var(--border); color: var(--text-secondary); text-decoration:none;">
        <i class="fas fa-arrow-left" style="margin-right: 10px; font-size: 0.8rem; color: var(--primary);"></i> Back
    </a>
    <h1>Reports</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Attendance</h3>
            <div class="number"><?php echo $total_present; ?></div>
        </div>
        <div class="stat-card">
            <h3>Daily Average</h3>
            <div class="number"><?php echo $avg_attendance; ?></div>
        </div>
        <div class="stat-card">
            <h3>Peak Day</h3>
            <div class="number"><?php echo $peak_day; ?></div>
        </div>
    </div>
    
    <div class="chart-container">
        <h2>Weekly Attendance Trend</h2>
        <div style="height: 300px;">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>

    <div class="table-box">
        <h3>Recent Attendance</h3>
        <table>
            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM attendance ORDER BY Date DESC LIMIT 5"; 
                $res = mysqli_query($conn, $query);

                if($res && mysqli_num_rows($res) > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        echo "<td>" . $row['MemberID'] . "</td>";
                        echo "<td>" . date('d M Y', strtotime($row['Date'])) . "</td>";
                        echo "<td>Present</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='empty-state'>No attendance records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('attendanceChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(255, 60, 0, 0.15)');
gradient.addColorStop(1, 'rgba(255, 60, 0, 0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($days); ?>,
        datasets: [{
            label: 'Members Present',
            data: <?php echo json_encode($attendance_data); ?>,
            borderColor: '#ff3c00',
            backgroundColor: gradient,
            borderWidth: 2,
            pointBackgroundColor: '#ff3c00',
            pointBorderColor: '#111111',
            pointRadius: 4,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { color: '#1f1f1f' }, ticks: { color: '#666666' } },
            x: { grid: { display: false }, ticks: { color: '#666666' } }
        }
    }
});
</script>

</body>
</html>