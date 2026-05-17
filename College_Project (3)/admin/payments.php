<?php include "../Backend/db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments · Smart Gym</title>
    <link rel="stylesheet" href="ldq.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
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

        /* Sidebar */
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

        .header-actions {
            display: flex;
            gap: 1rem;
        }

        .filter-btn {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .filter-btn i {
            font-size: 0.9rem;
        }

        /* Table */
        .table-box {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .table-header h3 {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
        }

        .search-box i {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .search-box input {
            background: transparent;
            border: none;
            color: var(--text-primary);
            font-size: 0.9rem;
            outline: none;
            width: 200px;
        }

        .search-box input::placeholder {
            color: var(--text-muted);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 1rem 1.5rem;
            background: var(--bg-primary);
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 1rem 1.5rem;
            color: var(--text-primary);
            font-size: 0.95rem;
            border-bottom: 1px solid var(--border);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            background: var(--bg-primary);
            border: 1px solid transparent;
        }

        .status-badge.paid {
            color: var(--success);
            border-color: rgba(16, 185, 129, 0.3);
            background: rgba(16, 185, 129, 0.1);
        }

        .status-badge.pending {
            color: var(--warning);
            border-color: rgba(245, 158, 11, 0.3);
            background: rgba(245, 158, 11, 0.1);
        }

        .status-badge i {
            font-size: 0.8rem;
        }

        /* Payment Button */
        .pay-btn {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-secondary);
            padding: 0.4rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pay-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(255, 60, 0, 0.05);
        }

        .pay-btn i {
            font-size: 0.8rem;
        }

        .paid-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            color: var(--success);
            font-size: 0.9rem;
        }

        .paid-badge i {
            font-size: 1rem;
        }

        /* Amount */
        .amount {
            font-weight: 500;
            color: var(--text-primary);
        }

        .amount i {
            color: var(--primary);
            margin-right: 0.2rem;
            font-size: 0.8rem;
        }

        /* Member Name */
        .member-name {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .member-avatar {
            width: 28px;
            height: 28px;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        /* Date */
        .date {
            color: var(--text-secondary);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .date i {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* No data */
        .no-data {
            text-align: center;
            padding: 3rem;
            color: var(--text-muted);
        }

        .no-data i {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0.3;
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
        @media (max-width: 1024px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }
            
            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .header-actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            .table-header {
                flex-direction: column;
                gap: 1rem;
            }
            
            .search-box input {
                width: 100%;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2><i class="fas fa-dumbbell"></i> SMART GYM</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="members.php">Members</a>
    <a href="qr.php">Attendance</a>
    <a href="payments.php" class="active">Payments</a>
    <a href="reports.php">Reports</a>
    <a href="trainers.php">Trainers</a>
    <a href="login.html" class="logout-btn">Logout</a>
</div>

<div class="main-content">
    <div class="page-header">
        <h1>Payments</h1>
        <div class="header-actions">
            <button class="filter-btn" onclick="filterPending()">
                <i class="fas fa-clock"></i> Pending
            </button>
            <button class="filter-btn" onclick="filterPaid()">
                <i class="fas fa-check-circle"></i> Paid
            </button>
            <button class="filter-btn" onclick="showAll()">
                <i class="fas fa-list"></i> All
            </button>
        </div>
    </div>

    <div class="table-box">
        <div class="table-header">
            <h3>Payment History</h3>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search member..." onkeyup="searchTable()">
            </div>
        </div>

        <table id="paymentTable">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM members ORDER BY name");
                    
                if(mysqli_num_rows($res) > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        $initial = strtoupper(substr($row['name'], 0, 1));
                        
                        // Set payment date based on status
                        if($row['fees_status'] == 'Paid') {
                            // If paid, show current date as payment date (you might want to store actual payment date)
                            $payment_date = date('d M Y');
                        } else {
                            // For pending, show no payment date
                            $payment_date = '—';
                        }
                ?>
                <tr data-status="<?php echo strtolower($row['fees_status']); ?>">
                    <td>
                        <div class="member-name">
                            <div class="member-avatar"><?php echo $initial; ?></div>
                            <?php echo htmlspecialchars($row['name']); ?>
                        </div>
                    </td>
                    <td>
                        <span class="date">
                            <i class="far fa-calendar-check"></i>
                            <?php echo $payment_date; ?>
                        </span>
                    </td>
                    <td>
                        <span class="status-badge <?php echo strtolower($row['fees_status']); ?>">
                            <i class="fas <?php echo ($row['fees_status'] == 'Paid') ? 'fa-check-circle' : 'fa-clock'; ?>"></i>
                            <?php echo $row['fees_status']; ?>
                        </span>
                    </td>
                    <td>
                        <?php if($row['fees_status'] == 'Pending') { ?>
                            <button class="pay-btn" onclick="payNow('<?php echo $row['id']; ?>', '<?php echo htmlspecialchars($row['name']); ?>')">
                                <i class="fas fa-credit-card"></i> Pay Now
                            </button>
                        <?php } else { ?>
                            <span class="paid-badge">
                                <i class="fas fa-check-circle"></i> Paid
                            </span>
                        <?php } ?>
                    </td>
                </tr>
                <?php 
                    }
                } else { 
                ?>
                <tr>
                    <td colspan="4" class="no-data">
                        <i class="fas fa-credit-card"></i>
                        <p>No payment records found</p>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Payment function
function payNow(id, name) {
    if(confirm("Process payment for " + name + "?")) {
        window.location.href = "../Backend/update-payment.php?id=" + id;
    }
}

// Search function
function searchTable() {
    let input = document.getElementById('searchInput');
    let filter = input.value.toUpperCase();
    let table = document.getElementById('paymentTable');
    let tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName('td')[0];
        if (td) {
            let txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}

// Filter functions
function filterPending() {
    let rows = document.querySelectorAll('#paymentTable tbody tr');
    rows.forEach(row => {
        let status = row.getAttribute('data-status');
        if(status === 'pending') {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function filterPaid() {
    let rows = document.querySelectorAll('#paymentTable tbody tr');
    rows.forEach(row => {
        let status = row.getAttribute('data-status');
        if(status === 'paid') {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function showAll() {
    let rows = document.querySelectorAll('#paymentTable tbody tr');
    rows.forEach(row => {
        row.style.display = '';
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('Payments page loaded');
});
</script>

</body>
</html>