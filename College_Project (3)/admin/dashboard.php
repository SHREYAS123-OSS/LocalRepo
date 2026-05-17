<?php
include "../Backend/db.php";

/* Total Members */
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM members");
$totalData = mysqli_fetch_assoc($totalQuery);
$totalMembers = $totalData['total'];

/* Paid Members */
$paidQuery = mysqli_query($conn, "SELECT COUNT(*) as paid FROM members WHERE fees_status='Paid'");
$paidData = mysqli_fetch_assoc($paidQuery);
$paidMembers = $paidData['paid'];

/* Pending Members */
$pendingQuery = mysqli_query($conn, "SELECT COUNT(*) as pending FROM members WHERE fees_status='Pending'");
$pendingData = mysqli_fetch_assoc($pendingQuery);
$pendingMembers = $pendingData['pending'];

$chartLabels = json_encode(['Total Members', 'Paid Members', 'Pending Fees']);
$chartData = json_encode([(int)$totalMembers, (int)$paidMembers, (int)$pendingMembers]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard · SMART GYM</title>
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

        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 2rem;
            font-weight: 500;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .date-badge {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .date-badge i {
            color: var(--primary);
            font-size: 0.9rem;
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1.5rem;
            transition: var(--transition);
        }

        .stat-card:hover {
            border-color: var(--border-light);
            transform: translateY(-2px);
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stat-label i {
            color: var(--primary);
            font-size: 0.9rem;
        }

        .stat-value {
            color: var(--text-primary);
            font-size: 2rem;
            font-weight: 600;
        }

        .stat-card:first-child .stat-value {
            color: var(--primary);
        }

        .stat-card:nth-child(2) .stat-value {
            color: var(--success);
        }

        .stat-card:last-child .stat-value {
            color: var(--warning);
        }

        /* Dashboard Section */
        .dashboard-section {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1.5rem;
        }

        .dashboard-section h2 {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dashboard-section h2 i {
            color: var(--primary);
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }

        canvas {
            max-height: 400px;
            width: 100% !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }
            
            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .stats-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar - Matching payments page style with dumbbell icon -->
<div class="sidebar">
    <h2><i class="fas fa-dumbbell"></i> SMART GYM</h2>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="members.php">Members</a>
    <a href="qr.php">Attendance</a>
    <a href="payments.php">Payments</a>
    <a href="reports.php">Reports</a>
    <a href="trainers.php">Trainers</a>
    <a href="../public/login.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
</div>

<div class="main-content">
    <a href="javascript:history.back()" style="border-bottom: 1px solid var(--border); color: var(--text-secondary); text-decoration:none;">
        <i class="fas fa-arrow-left" style="margin-right: 10px; font-size: 0.8rem; color: var(--primary);"></i> Back
    </a>
    <div class="page-header">
        <h1>Dashboard</h1>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i>
            <span id="currentDate"></span>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">
                <i class="fas fa-users"></i> Total Members
            </div>
            <div class="stat-value"><?php echo $totalMembers; ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">
                <i class="fas fa-check-circle" style="color: var(--success);"></i> Paid Members
            </div>
            <div class="stat-value"><?php echo $paidMembers; ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">
                <i class="fas fa-clock" style="color: var(--warning);"></i> Pending Fees
            </div>
            <div class="stat-value"><?php echo $pendingMembers; ?></div>
        </div>
    </div>

    <div class="dashboard-section">
        <h2>
            <i class="fas fa-chart-pie"></i>
            Membership Overview
        </h2>
        <div class="chart-container">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Current Date Display
function updateDate() {
    const now = new Date();
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
}
updateDate();

// Chart Configuration
const ctx = document.getElementById('attendanceChart').getContext('2d');

// Dark theme colors matching the design system
const chartColors = {
    total: '#ff3c00',
    paid: '#10b981',
    pending: '#f59e0b'
};

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: <?php echo $chartLabels; ?>,
        datasets: [{
            data: <?php echo $chartData; ?>,
            backgroundColor: [
                chartColors.total,
                chartColors.paid,
                chartColors.pending
            ],
            borderColor: '#111111',
            borderWidth: 2,
            hoverOffset: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '65%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#aaaaaa',
                    font: {
                        size: 12,
                        family: "'Inter', sans-serif",
                        weight: '400'
                    },
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: '#111111',
                titleColor: '#ffffff',
                bodyColor: '#cccccc',
                borderColor: '#222222',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 6,
                titleFont: {
                    family: "'Inter', sans-serif",
                    size: 13,
                    weight: '500'
                },
                bodyFont: {
                    family: "'Inter', sans-serif",
                    size: 12
                },
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.raw || 0;
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let percentage = Math.round((value / total) * 100);
                        return `${label}: ${value} members (${percentage}%)`;
                    }
                }
            }
        }
    }
});
</script>

</body>
</html>