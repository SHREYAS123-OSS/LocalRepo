<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password · Smart Gym</title>
    
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
            --bg-primary: #0a0a0a;
            --bg-card: #111111;
            --text-primary: #ffffff;
            --text-secondary: #aaaaaa;
            --text-muted: #666666;
            --border: #222222;
            --transition: all 0.2s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reset-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            width: 90%;
            max-width: 360px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .logo i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .logo span {
            color: var(--text-primary);
        }

        h2 {
            font-size: 1.4rem;
            font-weight: 500;
            text-align: center;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .input-group {
            margin-bottom: 1rem;
        }

        .input-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.6rem 1rem;
            transition: var(--transition);
        }

        .input-wrapper:focus-within {
            border-color: var(--primary);
        }

        .input-wrapper i {
            color: var(--text-muted);
            font-size: 0.9rem;
            width: 16px;
        }

        .input-wrapper input {
            background: transparent;
            border: none;
            color: var(--text-primary);
            font-size: 0.9rem;
            width: 100%;
            outline: none;
        }

        .input-wrapper input::placeholder {
            color: var(--text-muted);
        }

        .primary-btn {
            background: var(--primary);
            color: var(--text-primary);
            border: none;
            border-radius: 6px;
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            margin: 1rem 0;
        }

        .primary-btn:hover {
            opacity: 0.9;
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--primary);
        }

        .back-link i {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="reset-card">
        <div class="logo">
            <i class="fas fa-dumbbell"></i>
            <span>SMART GYM</span>
        </div>

        <h2>Reset Password</h2>

        <form action="../Backend/reset_password.php" method="POST">
            <div class="input-group">
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="new_password" placeholder="New Password" required>
                </div>
            </div>

            <button type="submit" class="primary-btn">
                <i class="fas fa-sync-alt"></i> Update
            </button>
        </form>

        <a href="login.html" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Login
        </a>
    </div>
</body>
</html>