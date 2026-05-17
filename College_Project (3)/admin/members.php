<?php
include "../Backend/db.php";
include "../Backend/fetch-members.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members · SMART GYM</title>
    
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

        h1 {
            font-size: 2rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 2rem;
            letter-spacing: -0.02em;
        }

        /* Horizontally Extended Card */
        .extended-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            width: 100%;
            transition: var(--transition);
        }

        .extended-card:hover {
            border-color: var(--border-light);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border);
        }

        .card-header h3 {
            color: var(--text-primary);
            font-size: 1.2rem;
            font-weight: 500;
        }

        .card-header span {
            color: var(--primary);
            font-size: 0.85rem;
            background: rgba(255, 60, 0, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            border: 1px solid var(--border);
        }

        /* Extended Fields */
        .extended-fields {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            width: 100%;
        }

        .field-row-full {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.4rem 1rem;
            transition: var(--transition);
            width: 100%;
            height: 48px;
        }

        .field-row-full:hover {
            border-color: var(--border-light);
        }

        .field-row-full:focus-within {
            border-color: var(--primary);
        }

        .field-icon-small {
            color: var(--text-muted);
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .field-row-full input {
            background: transparent;
            border: none;
            color: var(--text-primary);
            font-size: 0.9rem;
            width: 100%;
            padding: 0.2rem 0;
            height: 100%;
        }

        .field-row-full input:focus {
            outline: none;
        }

        .field-row-full input::placeholder {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .add-member-btn-full {
            width: 100%;
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--border);
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 400;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            height: 48px;
        }

        .add-member-btn-full:hover {
            border-color: var(--primary);
            background: rgba(255, 60, 0, 0.05);
        }

        .btn-icon {
            font-size: 1rem;
            color: var(--primary);
        }

        /* Search Input */
        .section-title {
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.8rem;
        }

        #searchInput {
            width: 100%;
            padding: 0.6rem 1.5rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 50px;
            color: var(--text-primary);
            font-size: 0.9rem;
            margin-bottom: 2rem;
            transition: var(--transition);
            height: 48px;
        }

        #searchInput:focus {
            outline: none;
            border-color: var(--primary);
        }

        #searchInput::placeholder {
            color: var(--text-muted);
        }

        /* Table */
        #memberTable {
            width: 100%;
            border-collapse: collapse;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        #memberTable th {
            text-align: left;
            padding: 0.8rem 1.5rem;
            background: var(--bg-primary);
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-bottom: 1px solid var(--border);
        }

        #memberTable td {
            padding: 0.8rem 1.5rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border);
        }

        #memberTable tr:last-child td {
            border-bottom: none;
        }

        #memberTable tbody tr:hover td {
            background: var(--bg-card);
        }

        /* Status Colors */
        .status-paid {
            color: var(--success) !important;
            font-weight: 500;
        }
        
        .status-pending {
            color: var(--warning) !important;
            font-weight: 500;
        }

        /* Delete Link */
        #memberTable a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            transition: var(--transition);
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            border: 1px solid transparent;
        }

        #memberTable a:hover {
            color: var(--danger);
            border-color: var(--border);
            background: rgba(239, 68, 68, 0.1);
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
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-right: none;
                border-bottom: 1px solid var(--border);
                padding: 1rem;
            }
            
            .sidebar h2 {
                margin-bottom: 1rem;
            }
            
            .sidebar a {
                display: inline-block;
                padding: 0.5rem 1rem;
                border-bottom: none;
            }
            
            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }
            
            #memberTable {
                display: block;
                overflow-x: auto;
            }
            
            .extended-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar - Payments Page Style -->
<div class="sidebar">
    <h2><i class="fas fa-dumbbell"></i> SMART GYM</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="members.php" class="active">Members</a>
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
    <h1>Members Management</h1>

    <!-- Horizontally Extended Card with Full Width Fields -->
    <div class="extended-card">
        <div class="card-header">
            <h3>Add New Member</h3>
            <span>New Registration</span>
        </div>
        
        <form action="../Backend/add-member.php" method="POST">
            <!-- Extended Fields - Full Width with Smaller Height -->
            <div class="extended-fields">
                <!-- Name Field -->
                <div class="field-row-full">
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                
                <!-- Email Field -->
                <div class="field-row-full">
                    <input type="text" name="mobile" placeholder="Mobile Number" 
                    pattern="[0-9]{10}" maxlength="10" title="कृपया १० अंकी मोबाईल नंबर टाका" required>
                </div>
                
                <!-- Plan Field -->
                <div class="field-row-full">
                    <input type="text" name="plan" placeholder="Membership Plan" required>
                </div>
            </div>
            
            
            <!-- Add Member Button -->
            <button type="submit" class="add-member-btn-full">
                Add Member
            </button>
        </form>
    </div>

    <!-- Search Input -->
    <div class="section-title">Search Members</div>
    <input type="text" id="searchInput" placeholder="Search by name, email or plan..." onkeyup="searchMember()">

    <!-- Table -->
    <table id="memberTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile No.</th>
                <th>Plan</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                <td><?php echo htmlspecialchars($row['plan']); ?></td>
                <td class="status-<?php echo strtolower($row['fees_status']); ?>"><?php echo $row['fees_status']; ?></td>
                <td>
                    <a href="../Backend/delete-member.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this member?')">
                        Delete
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="ldq.js"></script>
<script>
// Search functionality
function searchMember() {
    let input = document.getElementById('searchInput');
    let filter = input.value.toUpperCase();
    let table = document.getElementById('memberTable');
    let tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        let tdName = tr[i].getElementsByTagName('td')[1];
        let tdMobile = tr[i].getElementsByTagName('td')[2];
        let tdPlan = tr[i].getElementsByTagName('td')[3];
        
        if (tdName || tdEmail || tdPlan) {
            let nameValue = tdName.textContent || tdName.innerText;
            let mobileValue = tdMobile.textContent || tdMobile.innerText;
            let planValue = tdPlan.textContent || tdPlan.innerText;
            
            if (nameValue.toUpperCase().indexOf(filter) > -1 || 
                mobileValue.toUpperCase().indexOf(filter) > -1 ||
                planValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}

// Ensure status colors are applied
document.addEventListener('DOMContentLoaded', function() {
    const statusCells = document.querySelectorAll('#memberTable tbody td:nth-child(5)');
    statusCells.forEach(cell => {
        if (cell.textContent === 'Paid') {
            cell.classList.add('status-paid');
        } else if (cell.textContent === 'Pending') {
            cell.classList.add('status-pending');
        }
    });
});
</script>

</body>
</html>