<?php 
session_start();
include "../Backend/db.php"; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Trainers · SMART GYM</title>
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

        h1 {
            font-size: 2rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 2rem;
            letter-spacing: -0.02em;
        }

        /* Rest of your existing Trainer Styles */
        .primary-btn {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--border);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 400;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 2rem;
        }

        .primary-btn:hover {
            border-color: var(--primary);
            background: rgba(255, 60, 0, 0.05);
        }

        .trainer-sections {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .trainer-section {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: var(--transition);
            position: relative;
        }

        .trainer-section:hover {
            border-color: var(--border-light);
            transform: translateY(-2px);
        }

        .trainer-name {
            color: var(--text-primary);
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .trainer-specialization {
            background: var(--bg-primary);
            color: var(--primary);
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
            display: inline-block;
        }

        .delete-btn {
            color: var(--text-muted);
            background: transparent;
            padding: 0.6rem 1.5rem;
            border-radius: 6px;
            font-size: 0.9rem;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid var(--border);
            display: inline-block;
        }

        .delete-btn:hover {
            color: var(--danger);
            border-color: var(--danger);
            background: rgba(239, 68, 68, 0.1);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: var(--bg-secondary);
            margin: 10% auto;
            padding: 2rem;
            width: 90%;
            max-width: 480px;
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .modal-content h3 { color: #fff; margin-bottom: 1.5rem; text-align: center; }

        .modal-content input {
            width: 100%;
            padding: 0.75rem 1rem;
            margin: 0.5rem 0 1rem 0;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: #fff;
        }

        .modal-content input:focus { outline: none; border-color: var(--primary); }

        .modal-actions { display: flex; gap: 1rem; margin-top: 1.5rem; }

        .modal-actions button { flex: 1; padding: 0.75rem; border-radius: 6px; cursor: pointer; background: transparent; border: 1px solid var(--border); transition: 0.2s; }

        .modal-actions button[type="submit"] { color: var(--primary); }
        .modal-actions button[type="submit"]:hover { border-color: var(--primary); background: rgba(255, 60, 0, 0.05); }
        
        .modal-actions button[type="button"] { color: var(--text-muted); }
        .modal-actions button[type="button"]:hover { color: #fff; border-color: var(--text-secondary); }

        .trainer-id-badge { color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.5rem; font-family: monospace; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class="fas fa-dumbbell"></i> SMART GYM</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="members.php">Members</a>
    <a href="qr.php">Attendance</a>
    <a href="payments.php">Payments</a>
    <a href="reports.php">Reports</a>
    <a href="trainers.php" class="active">Trainers</a>
    <a href="../public/login.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
</div>

<div class="main-content">
    <a href="javascript:history.back()" style="border-bottom: 1px solid var(--border); color: var(--text-secondary); text-decoration:none;">
        <i class="fas fa-arrow-left" style="margin-right: 10px; font-size: 0.8rem; color: var(--primary);"></i> Back
    </a>
    <h1>Trainers Management</h1>

    <button class="primary-btn" onclick="document.getElementById('addModal').style.display='block'">+ Add Trainer</button>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <h3>Add New Trainer</h3>
            <form action="../Backend/add_trainer.php" method="POST">
                <input type="text" name="name" placeholder="Trainer Full Name" required>
                <input type="text" name="specialization" placeholder="Specialization (e.g. Yoga Specialist)" required>
                <input type="password" name="password" placeholder="Set Password (for login)" required>
                
                <div class="modal-actions">
                    <button type="submit">Save Trainer</button>
                    <button type="button" onclick="document.getElementById('addModal').style.display='none'">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    $query = "SELECT * FROM trainers";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0) {
    ?>
    <div class="trainer-sections">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="trainer-section">
            <div class="trainer-id-badge">ID: <?php echo $row['TrainerID']; ?></div>
            <div class="trainer-name"><?php echo htmlspecialchars($row['Name']); ?></div>
            <div class="trainer-specialization"><?php echo htmlspecialchars($row['Specialization']); ?></div>
            <a href="../Backend/delete_trainer.php?id=<?php echo $row['TrainerID']; ?>" 
               class="delete-btn"
               onclick="return confirm('Do you really want to delete?')">Delete</a>
        </div>
        <?php } ?>
    </div>
    <?php
    } else {
        echo '<div style="text-align: center; padding: 4rem; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 12px; color: var(--text-muted);">';
        echo '<p style="margin-bottom: 1.5rem;">No trainers added yet</p>';
        echo '<button class="primary-btn" onclick="document.getElementById(\'addModal\').style.display=\'block\'">+ Add Your First Trainer</button>';
        echo '</div>';
    }
    ?>
</div>

<script>
document.getElementById('addModal').addEventListener('click', function(e) {
    if(e.target === this) { this.style.display = 'none'; }
});

document.addEventListener('keydown', function(e) {
    if(e.key === 'Escape') { document.getElementById('addModal').style.display = 'none'; }
});
</script>

</body>
</html>