<?php include "../Backend/db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Plan Details | Smart Gym</title>
    <!-- Google Fonts: Poppins for modern look (same as main page) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons (optional, but adds refinement) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* minimalist dark theme – consistent with gym system dark theme but cleaner */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #0e0e12;        /* deep dark background */
            --bg-secondary: #16161c;       /* subtle card background */
            --border-light: #2c2c34;        /* soft border */
            --text-primary: #ededef;        /* nearly white */
            --text-secondary: #a0a0ab;      /* muted gray */
            --accent: #ff5e5e;              /* soft red – primary color */
            --accent-dim: #cc4f4f;           /* darker accent for hover */
            --font-sans: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            font-family: var(--font-sans);
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .plan-container {
            max-width: 720px;
            width: 100%;
            background: var(--bg-secondary);
            border-radius: 28px;
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.7);
            border: 1px solid var(--border-light);
            transition: transform 0.2s ease;
        }

        /* subtle hover lift (optional) */
        .plan-container:hover {
            transform: translateY(-4px);
        }

        /* header with accent underline */
        .program-header {
            margin-bottom: 2.5rem;
            text-align: left;
            border-bottom: 1px solid var(--border-light);
            padding-bottom: 1.2rem;
        }

        .program-header h1 {
            font-size: 2.2rem;
            font-weight: 500;
            letter-spacing: -0.02em;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .program-header .type-badge {
            display: inline-block;
            margin-top: 0.4rem;
            font-size: 0.9rem;
            font-weight: 400;
            color: var(--text-secondary);
            background: rgba(255, 94, 94, 0.08);
            padding: 0.2rem 1rem;
            border-radius: 40px;
            border: 1px solid rgba(255, 94, 94, 0.2);
        }

        /* details card – minimal, no heavy border-left, just clean separation */
        .details-box {
            background: transparent;
            padding: 0.5rem 0 1rem 0;
        }

        .section-block {
            margin-bottom: 2rem;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .section-title i {
            color: var(--accent);
            font-size: 1.4rem;
            width: 28px;
        }

        /* minimalist list */
        .plan-list {
            list-style: none;
            margin-left: 2.2rem; /* align with icon indent */
        }

        .plan-list li {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: baseline;
            gap: 0.5rem;
            font-weight: 400;
        }

        .plan-list li i {
            color: var(--accent);
            font-size: 0.7rem;
            width: 18px;
            text-align: center;
            margin-right: 0.2rem;
            opacity: 0.9;
        }

        /* subtle divider between sections */
        .section-divider {
            height: 1px;
            background: var(--border-light);
            margin: 2rem 0 1.8rem 0;
            width: 100%;
        }

        /* back link – minimal & elegant */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.8rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 400;
            border: 1px solid var(--border-light);
            padding: 0.6rem 1.4rem;
            border-radius: 60px;
            transition: all 0.2s;
        }

        .back-link i {
            font-size: 0.85rem;
            color: var(--accent);
            transition: transform 0.2s;
        }

        .back-link:hover {
            border-color: var(--accent);
            color: var(--text-primary);
            background: rgba(255, 94, 94, 0.03);
        }

        .back-link:hover i {
            transform: translateX(-3px);
        }

        /* no extra ornament, no thick left border – clean */
        hr {
            border: none;
            border-top: 1px solid var(--border-light);
            margin: 2rem 0 1.5rem;
        }

        /* if no plan is found (fallback) */
        .fallback-text {
            color: var(--text-secondary);
            margin: 2rem 0;
            font-style: italic;
        }

        /* responsive */
        @media (max-width: 500px) {
            .plan-container {
                padding: 2rem 1.5rem;
            }
            .program-header h1 {
                font-size: 1.9rem;
            }
            .plan-list {
                margin-left: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="plan-container">
        <?php
            // sanitize input
            $plan = isset($_GET['type']) ? htmlspecialchars(trim($_GET['type'])) : 'General';
        ?>

        <!-- header with minimal badge -->
        <div class="program-header">
            <h1><?php echo $plan; ?></h1>
            <span class="type-badge">personalized program</span>
        </div>

        <div class="details-box">
            <?php if ($plan == "Weight Loss"): ?>
                <!-- EXERCISE SECTION -->
                <div class="section-block">
                    <div class="section-title">
                        <i class="fas fa-running"></i>
                        <span>Exercise Plan</span>
                    </div>
                    <ul class="plan-list">
                        <li><i class="fas fa-circle"></i> 30 min Cardio (Running / Cycling)</li>
                        <li><i class="fas fa-circle"></i> High Intensity Interval Training (HIIT)</li>
                        <li><i class="fas fa-circle"></i> Burpees & Jumping Jacks</li>
                    </ul>
                </div>

                <!-- subtle divider instead of big border -->
                <div class="section-divider"></div>

                <!-- DIET SECTION -->
                <div class="section-block">
                    <div class="section-title">
                        <i class="fas fa-utensils"></i>
                        <span>Diet Guidance</span>
                    </div>
                    <ul class="plan-list">
                        <li><i class="fas fa-circle"></i> High Protein, Low Carbs</li>
                        <li><i class="fas fa-circle"></i> Green Tea & Fresh Salads</li>
                        <li><i class="fas fa-circle"></i> Avoid Sugar & Junk Food</li>
                    </ul>
                </div>

            <?php elseif ($plan == "Muscle Gain"): ?>
                <div class="section-block">
                    <div class="section-title">
                        <i class="fas fa-dumbbell"></i>
                        <span>Exercise Plan</span>
                    </div>
                    <ul class="plan-list">
                        <li><i class="fas fa-circle"></i> Heavy Weight Lifting (compound focus)</li>
                        <li><i class="fas fa-circle"></i> Deadlifts & Squats</li>
                        <li><i class="fas fa-circle"></i> Bench Press & Bicep Curls</li>
                    </ul>
                </div>
                <div class="section-divider"></div>
                <div class="section-block">
                    <div class="section-title">
                        <i class="fas fa-egg"></i>
                        <span>Diet Guidance</span>
                    </div>
                    <ul class="plan-list">
                        <li><i class="fas fa-circle"></i> High Calorie Intake (lean bulk)</li>
                        <li><i class="fas fa-circle"></i> Chicken, Eggs, Paneer</li>
                        <li><i class="fas fa-circle"></i> Post-workout Protein Shake</li>
                    </ul>
                </div>

            <?php elseif ($plan == "Strength Training"): ?>
                <div class="section-block">
                    <div class="section-title">
                        <i class="fas fa-weight-hanging"></i>
                        <span>Exercise Plan</span>
                    </div>
                    <ul class="plan-list">
                        <li><i class="fas fa-circle"></i> Compound Movements (big three)</li>
                        <li><i class="fas fa-circle"></i> Powerlifting technique work</li>
                        <li><i class="fas fa-circle"></i> Overhead Press & Rows</li>
                    </ul>
                </div>
                <div class="section-divider"></div>
                <div class="section-block">
                    <div class="section-title">
                        <i class="fas fa-carrot"></i>
                        <span>Diet Guidance</span>
                    </div>
                    <ul class="plan-list">
                        <li><i class="fas fa-circle"></i> Balanced Macro-nutrients</li>
                        <li><i class="fas fa-circle"></i> Complex Carbs (Oats / Rice)</li>
                        <li><i class="fas fa-circle"></i> Hydration is Key (3L+)</li>
                    </ul>
                </div>

            <?php elseif ($plan == "Cardio Blast"): ?>
                <div class="section-block">
                    <div class="section-title">
                        <i class="fas fa-bicycle"></i>
                        <span>Exercise Plan</span>
                    </div>
                    <ul class="plan-list">
                        <li><i class="fas fa-circle"></i> Treadmill Sprints (HIIT)</li>
                        <li><i class="fas fa-circle"></i> Cycling & Rowing intervals</li>
                        <li><i class="fas fa-circle"></i> Zumba or Aerobics</li>
                    </ul>
                </div>
                <div class="section-divider"></div>
                <div class="section-block">
                    <div class="section-title">
                        <i class="fas fa-apple-alt"></i>
                        <span>Diet Guidance</span>
                    </div>
                    <ul class="plan-list">
                        <li><i class="fas fa-circle"></i> Light Meals before workout</li>
                        <li><i class="fas fa-circle"></i> Fruits & Electrolytes</li>
                        <li><i class="fas fa-circle"></i> Low Fat, high energy</li>
                    </ul>
                </div>

            <?php else: ?>
                <!-- fallback for any other / general -->
                <div class="section-block">
                    <div class="section-title">
                        <i class="fas fa-heartbeat"></i>
                        <span>General Fitness</span>
                    </div>
                    <p class="fallback-text">Please select a specific program to see details.</p>
                </div>
            <?php endif; ?>

            <!-- minimal back link with arrow icon -->
            <a href="index.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to home
            </a>
        </div> <!-- end details-box -->
    </div> <!-- end plan-container -->
</body>
</html>