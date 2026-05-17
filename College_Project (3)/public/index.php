<?php
include "../Backend/db.php";

function getMemberCount($conn){
    $query = mysqli_query($conn,"SELECT COUNT(*) as total FROM members");
    $row = mysqli_fetch_assoc($query);
    return $row['total'];
}

function getTrainerCount($conn){
    $query = mysqli_query($conn,"SELECT COUNT(*) as total FROM trainers");
    $row = mysqli_fetch_assoc($query);
    return $row['total'];
}
?>

<?php
// Start session for potential user data
session_start();

// Database configuration (you'll need to update these)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gym_management');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newsletter_subscribe'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        // Process newsletter subscription
        $subscription_message = "Thank you for subscribing!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Smart Gym Management System - Track attendance, manage memberships, and achieve fitness goals with QR code technology">
    <meta name="keywords" content="gym management, QR code attendance, fitness tracking, membership management">
    <meta name="author" content="Smart Gym">
    <title>Smart Gym Management System - QR Based Attendance</title>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #ff4d4d;
            --primary-dark: #cc0000;
            --secondary-color: #2c3e50;
            --accent-color: #00d68f;
            --bg-primary: #0a0a0f;
            --bg-secondary: #13131a;
            --bg-card: #1c1c24;
            --bg-card-hover: #24242e;
            --text-primary: #ffffff;
            --text-secondary: #b3b3b3;
            --text-muted: #808080;
            --border-color: #2a2a35;
            --shadow: 0 5px 20px rgba(0,0,0,0.3);
            --shadow-hover: 0 8px 30px rgba(0,0,0,0.5);
            --gradient: linear-gradient(135deg, #ff4d4d, #ff6b6b);
            --gradient-dark: linear-gradient(135deg, #cc0000, #ff4d4d);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
            background: var(--bg-primary);
        }

        /* Preloader */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-primary);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        .preloader.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid var(--bg-card);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: transparent;
            padding: 1.5rem 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .navbar.scrolled {
            background: rgba(10, 10, 15, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar.scrolled .logo span,
        .navbar.scrolled .nav-menu a {
            color: var(--text-primary);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .logo i {
            color: var(--primary-color);
            font-size: 2rem;
        }

        .logo span {
            color: var(--text-primary);
            transition: var(--transition);
        }

        .logo .highlight {
            color: var(--primary-color);
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: var(--transition);
        }

        .nav-menu a:hover::after,
        .nav-menu a.active::after {
            width: 100%;
        }

        .nav-buttons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--gradient);
            color: var(--text-primary);
            box-shadow: 0 4px 15px rgba(255,77,77,0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,77,77,0.4);
        }

        .btn-outline {
            border: 2px solid var(--primary-color);
            color: var(--text-primary);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: var(--text-primary);
        }

        .btn-outline-light {
            border: 2px solid var(--text-primary);
            color: var(--text-primary);
            background: transparent;
        }

        .btn-outline-light:hover {
            background: var(--text-primary);
            color: var(--bg-primary);
        }

        .btn-large {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
        }

        .btn-small {
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
        }

        .btn-block {
            display: block;
            width: 100%;
            text-align: center;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: var(--text-primary);
            transition: var(--transition);
        }

        /* Hero Section */
        /* Hero Section Update */
    .hero {
        min-height: 100vh;
        /* इमेज पाथ व्यवस्थित तपासा, जर इमेज एकाच फोल्डरमध्ये असेल तर फक्त नाव टाका */
        background: url('gym-bg.jpg'); 
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed; /* इमेज स्क्रोल करताना स्थिर राहील */
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.8) 100%);
        }

        .hero .container {
            position: relative;
            z-index: 2;
        }

        .hero-content {
            max-width: 800px;
        }

        .badge {
            display: inline-block;
            background: rgba(255,77,77,0.1);
            backdrop-filter: blur(5px);
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255,77,77,0.2);
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 700;
            line-height: 1.2;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--primary-color), #ff8e8e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 2.5rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .hero-stats {
            display: flex;
            gap: 3rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .hero-shape {
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            height: 100px;
            background: var(--bg-primary);
            transform: skewY(-3deg);
            z-index: 1;
        }

        /* Sections */
        .section {
            padding: 100px 0;
            background: var(--bg-primary);
        }

        .section:nth-child(even) {
            background: var(--bg-secondary);
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-subtitle {
            display: inline-block;
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .section-header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* About Section */
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        .about-text p {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }
        .about-text .btn {
            margin-top: 1rem;
        }
        .about-image img {
            width: 100%;
            border-radius: 10px;
            box-shadow: var(--shadow-hover);
            border: 1px solid var(--border-color);
        }

        /* Updated Features Grid (replacing previous features) */
        .gym-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        .gym-feature-card {
            background: var(--bg-card);
            padding: 2rem 1.5rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: left;
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }
        .gym-feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
            background: var(--bg-card-hover);
            border-color: var(--primary-color);
        }
        .gym-feature-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .gym-feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.8rem;
            color: var(--text-primary);
        }
        .gym-feature-card p {
            color: var(--text-secondary);
            line-height: 1.7;
        }

        /* Workouts Grid (unchanged) */
        .workouts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .workout-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
            height: 300px;
            border: 1px solid var(--border-color);
        }

        .workout-image {
            height: 100%;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .workout-image.weight-loss {
            background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');
        }

        .workout-image.muscle-gain {
            background-image: url('https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');
        }

        .workout-image.strength {
            background-image: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');
        }

        .workout-image.cardio {
            background-image: url('https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');
        }

        .workout-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.95), rgba(0,0,0,0.4));
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2rem;
            color: var(--text-primary);
            opacity: 0;
            transition: var(--transition);
        }

        .workout-card:hover .workout-overlay {
            opacity: 1;
        }

        .workout-overlay h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .workout-overlay p {
            margin-bottom: 1rem;
            color: var(--text-secondary);
        }

        .workout-stats {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .workout-stats span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        /* Pricing Section (unchanged, but "Choose Plan" buttons removed later via modification) */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .pricing-card {
            background: var(--bg-card);
            border-radius: 10px;
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .pricing-card.featured {
            transform: scale(1.05);
            border: 2px solid var(--primary-color);
            box-shadow: var(--shadow-hover);
            background: var(--bg-card-hover);
        }

        .pricing-badge {
            position: absolute;
            top: 20px;
            right: -30px;
            background: var(--primary-color);
            color: var(--text-primary);
            padding: 0.3rem 2rem;
            transform: rotate(45deg);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .pricing-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .pricing-header h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .price {
            display: flex;
            align-items: baseline;
            justify-content: center;
            gap: 0.2rem;
        }

        .currency {
            font-size: 1.5rem;
            color: var(--text-secondary);
        }

        .amount {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .period {
            color: var(--text-secondary);
        }

        .pricing-features {
            list-style: none;
            margin-bottom: 2rem;
        }

        .pricing-features li {
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
        }

        .pricing-features i {
            width: 20px;
        }

        .pricing-features .fa-check {
            color: var(--accent-color);
        }

        .pricing-features .fa-times {
            color: var(--primary-color);
        }

        /* Testimonials */
        .testimonials {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .testimonials .section-header h2,
        .testimonials .section-header p {
            color: var(--text-primary);
        }

        .testimonials-slider {
            max-width: 800px;
            margin: 0 auto;
        }

        .testimonial-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 2rem;
        }

        .testimonial-content {
            position: relative;
        }

        .testimonial-content .fa-quote-left {
            font-size: 2rem;
            color: var(--primary-color);
            opacity: 0.3;
            margin-bottom: 1rem;
        }

        .testimonial-content p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.8;
            color: var(--text-secondary);
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .testimonial-author img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .testimonial-author h4 {
            font-size: 1.1rem;
            margin-bottom: 0.2rem;
            color: var(--text-primary);
        }

        .testimonial-author span {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        /* Newsletter Section (unchanged) */
        .newsletter {
            background: var(--bg-secondary);
            padding: 60px 0;
            text-align: center;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .newsletter h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .newsletter p {
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .newsletter-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
            gap: 1rem;
        }

        .newsletter-form input {
            flex: 1;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            font-size: 1rem;
            outline: none;
            transition: var(--transition);
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .newsletter-form input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255,77,77,0.1);
        }

        .newsletter-form input::placeholder {
            color: var(--text-muted);
        }

        .newsletter-form button {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            background: var(--primary-color);
            color: var(--text-primary);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .newsletter-form button:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Updated Footer */
        .footer {
            background: var(--bg-secondary);
            color: var(--text-primary);
            padding: 60px 0 20px;
            border-top: 1px solid var(--border-color);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 2fr; /* Adjust for map & contact */
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .footer-col {
            padding: 0 1rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .footer-logo i {
            color: var(--primary-color);
        }

        .footer-logo .highlight {
            color: var(--primary-color);
        }

        .footer-col p {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: var(--bg-card);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
            transition: var(--transition);
            border: 1px solid var(--border-color);
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
            border-color: var(--primary-color);
        }

        .footer-col h4 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .footer-col h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--primary-color);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 0.8rem;
        }

        .footer-col ul li a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-col ul li a:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        .contact-info li {
            color: var(--text-secondary);
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .contact-info i {
            color: var(--primary-color);
            margin-top: 0.2rem;
            width: 20px;
        }

        .map-container {
            margin-top: 1rem;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }
        .map-container iframe {
            width: 100%;
            height: 180px;
            border: 0;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .footer-bottom a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .footer-bottom a:hover {
            text-decoration: underline;
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: var(--text-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 999;
            border: 1px solid var(--border-color);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 3rem;
            }
            .pricing-card.featured {
                transform: scale(1);
            }
            .about-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }
            .nav-menu {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 80px);
                background: var(--bg-secondary);
                flex-direction: column;
                align-items: center;
                justify-content: center;
                transition: var(--transition);
                border-top: 1px solid var(--border-color);
            }
            .nav-menu.active {
                left: 0;
            }
            .nav-menu a {
                color: var(--text-primary);
                font-size: 1.2rem;
            }
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero-buttons {
                flex-direction: column;
            }
            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }
            .section-header h2 {
                font-size: 2rem;
            }
            .gym-features-grid,
            .workouts-grid,
            .pricing-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }
            .cta-buttons {
                flex-direction: column;
            }
            .newsletter-form {
                flex-direction: column;
                padding: 0 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }
            .btn-large {
                padding: 0.8rem 1.5rem;
            }
            .nav-buttons .btn-outline {
                display: none;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        [data-aos] {
            opacity: 0;
            transition-property: opacity, transform;
        }

        [data-aos].aos-animate {
            opacity: 1;
        }

        [data-aos="fade-up"] {
            transform: translateY(50px);
        }

        [data-aos="fade-up"].aos-animate {
            transform: translateY(0);
        }

        [data-aos="zoom-in"] {
            transform: scale(0.9);
        }

        [data-aos="zoom-in"].aos-animate {
            transform: scale(1);
        }

        [data-aos="flip-left"] {
            transform: perspective(2500px) rotateY(-100deg);
        }

        [data-aos="flip-left"].aos-animate {
            transform: perspective(2500px) rotateY(0);
        }

        /* Alert Messages */
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .alert-success {
            background: rgba(0, 214, 143, 0.1);
            color: var(--accent-color);
            border: 1px solid rgba(0, 214, 143, 0.2);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Selection Color */
        ::selection {
            background: var(--primary-color);
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Navbar -->
    <header class="navbar" id="navbar">
        <div class="container">
            <div class="logo">
                <i class="fas fa-dumbbell"></i>
                <span>SMART<span class="highlight">GYM</span></span>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="#home" class="active">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#gym-features">Facilities</a></li>
                    <li><a href="#workouts">Programs</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            <div class="nav-buttons">
                <a href="login.php" class="btn btn-outline">Login</a>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section (removed Member Since 2024 badge, Get Started & Learn More buttons) -->
    <section class="hero" id="home">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
                <!-- removed badge: Member Since 2024 -->
                <h1>Transform Your Body,<br><span class="gradient-text">Transform Your Life</span></h1>
                <p>Track attendance with QR codes, manage memberships, and achieve your fitness goals with our smart gym management system.</p>
                <div class="hero-buttons">
                    <!-- removed Get Started and Learn More buttons; only login/register available in nav -->
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number" data-target="<?php echo getMemberCount($conn); ?>">0</span>
                        <span class="stat-label">Happy Members</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="<?php echo getTrainerCount($conn); ?>">0</span>
                        <span class="stat-label">Expert Trainers</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="15">0</span>
                        <span class="stat-label">Years Experience</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-shape"></div>
    </section>

    <!-- About Us Section (new) -->
    <section class="section" id="about">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Our Story</span>
                <h2>About Smart Gym</h2>
                <p>Your partner in health and fitness since 2010</p>
            </div>
            <div class="about-content" data-aos="fade-up">
                <div class="about-text">
                    <p>At Smart Gym, we believe that fitness is more than just lifting weights – it's about building a healthier, happier community. Founded in 2010, we've grown from a small local gym to a modern fitness center equipped with state-of-the-art facilities and a team of dedicated professionals.</p>
                    <p>Our mission is to provide an inclusive environment where everyone, from beginners to elite athletes, can achieve their personal best. We combine innovative technology like QR code attendance with personalized training to make your fitness journey seamless and effective.</p>
                    <p>Join us and experience the difference of a gym that truly cares about your success.</p>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="About Smart Gym" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Gym Features Section (replaces old features) -->
    <section class="section" id="gym-features">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Our Facilities</span>
                <h2>Modern Equipment & Training Zones</h2>
                <p>Everything you need for a complete workout experience</p>
            </div>

            <div class="gym-features-grid">
                <div class="gym-feature-card" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-dumbbell"></i>
                    <h3>Modern Gym Equipment</h3>
                    <p>Latest machines from top brands: Technogym, Life Fitness, and Hammer Strength for effective training.</p>
                </div>
                <div class="gym-feature-card" data-aos="fade-up" data-aos-delay="150">
                    <i class="fas fa-heartbeat"></i>
                    <h3>Cardio Training Area</h3>
                    <p>Full range of treadmills, ellipticals, spin bikes, and rowers with personal entertainment screens.</p>
                </div>
                <div class="gym-feature-card" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-weight-hanging"></i>
                    <h3>Strength / Free Weights</h3>
                    <p>Power racks, Olympic platforms, and dumbbells up to 50kg for serious strength development.</p>
                </div>
                <div class="gym-feature-card" data-aos="fade-up" data-aos-delay="250">
                    <i class="fas fa-user-tie"></i>
                    <h3>Personal Training</h3>
                    <p>Certified trainers dedicated to crafting individualized programs and pushing your limits.</p>
                </div>
                <div class="gym-feature-card" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-users"></i>
                    <h3>Group Fitness Classes</h3>
                    <p>Yoga, HIIT, Zumba, and more – energetic classes led by expert instructors.</p>
                </div>
                <div class="gym-feature-card" data-aos="fade-up" data-aos-delay="350">
                    <i class="fas fa-apple-alt"></i>
                    <h3>Diet & Nutrition Guidance</h3>
                    <p>Get personalized meal plans and nutritional advice to complement your training.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Workout Programs (unchanged) -->
    <section class="section workouts" id="workouts">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Our Programs</span>
                <h2>Personalized Workout Plans</h2>
                <p>Choose the perfect program that matches your fitness goals</p>
            </div>

            <div class="workouts-grid">
                <div class="workout-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="workout-image weight-loss">
                        <div class="workout-overlay">
                            <h3>Weight Loss</h3>
                            <p>Burn fat and shed those extra pounds</p>
                            <div class="workout-stats">
                                <span><i class="fas fa-clock"></i> 45 min</span>
                                <span><i class="fas fa-fire"></i> 600 cal</span>
                            </div>
                            <a href="../admin/workout_details.php?type=Weight+Loss" class="btn btn-small">View Plan</a>
                        </div>
                    </div>
                </div>
                <div class="workout-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="workout-image muscle-gain">
                        <div class="workout-overlay">
                            <h3>Muscle Gain</h3>
                            <p>Build lean muscle and strength</p>
                            <div class="workout-stats">
                                <span><i class="fas fa-clock"></i> 60 min</span>
                                <span><i class="fas fa-dumbbell"></i> Advanced</span>
                            </div>
                            <a href="../admin/workout_details.php?type=Muscle+Gain" class="btn btn-small">View Plan</a>
                        </div>
                    </div>
                </div>
                <div class="workout-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="workout-image strength">
                        <div class="workout-overlay">
                            <h3>Strength Training</h3>
                            <p>Increase power and endurance</p>
                            <div class="workout-stats">
                                <span><i class="fas fa-clock"></i> 50 min</span>
                                <span><i class="fas fa-weight-hanging"></i> Heavy</span>
                            </div>
                            <a href="../admin/workout_details.php?type=Strength+Training" class="btn btn-small">View Plan</a>
                        </div>
                    </div>
                </div>
                <div class="workout-card" data-aos="zoom-in" data-aos-delay="400">
                    <div class="workout-image cardio">
                        <div class="workout-overlay">
                            <h3>Cardio Blast</h3>
                            <p>Improve heart health and stamina</p>
                            <div class="workout-stats">
                                <span><i class="fas fa-clock"></i> 40 min</span>
                                <span><i class="fas fa-heart"></i> High</span>
                            </div>
                            <a href="../admin/workout_details.php?type=Cardio+Blast" class="btn btn-small">View Plan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section (Choose Plan buttons removed) -->
    <section class="section pricing" id="pricing">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Membership Plans</span>
                <h2>Choose Your Perfect Plan</h2>
                <p>Flexible plans that fit your lifestyle and budget</p>
            </div>

            <div class="pricing-grid">
                <div class="pricing-card" data-aos="flip-left" data-aos-delay="100">
                    <div class="pricing-header">
                        <h3>Basic</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">29</span>
                            <span class="period">/month</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Gym Access (6am-8pm)</li>
                        <li><i class="fas fa-check"></i> 2 Group Classes/week</li>
                        <li><i class="fas fa-check"></i> Basic Fitness Assessment</li>
                        <li><i class="fas fa-times"></i> Personal Trainer</li>
                        <li><i class="fas fa-times"></i> Diet Plan</li>
                    </ul>
                    <!-- removed "Choose Plan" button -->
                </div>

                <div class="pricing-card featured" data-aos="flip-left" data-aos-delay="200">
                    <div class="pricing-badge">Best Value</div>
                    <div class="pricing-header">
                        <h3>Premium</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">49</span>
                            <span class="period">/month</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> 24/7 Gym Access</li>
                        <li><i class="fas fa-check"></i> Unlimited Group Classes</li>
                        <li><i class="fas fa-check"></i> Advanced Fitness Assessment</li>
                        <li><i class="fas fa-check"></i> 4 Personal Trainer Sessions</li>
                        <li><i class="fas fa-check"></i> Custom Diet Plan</li>
                    </ul>
                    <!-- removed "Choose Plan" button -->
                </div>

                <div class="pricing-card" data-aos="flip-left" data-aos-delay="300">
                    <div class="pricing-header">
                        <h3>Elite</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">79</span>
                            <span class="period">/month</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> 24/7 VIP Access</li>
                        <li><i class="fas fa-check"></i> Unlimited Classes + Workshops</li>
                        <li><i class="fas fa-check"></i> Monthly Health Checkup</li>
                        <li><i class="fas fa-check"></i> Unlimited PT Sessions</li>
                        <li><i class="fas fa-check"></i> Meal Prep Service</li>
                    </ul>
                    <!-- removed "Choose Plan" button -->
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials (unchanged) -->
    <section class="section testimonials">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Success Stories</span>
                <h2>What Our Members Say</h2>
                <p>Real results from real people</p>
            </div>

            <div class="testimonials-slider" id="testimonials-slider" data-aos="fade-up">
                <!-- Testimonials will be loaded via JavaScript -->
            </div>
        </div>
    </section>

    
    <!-- CTA Section (removed Join Now and Contact Us buttons as requested) -->
    <!-- section removed entirely -->

    <!-- Footer (redesigned as per instructions) -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-grid">
                <!-- Column 1: Contact Information -->
                <div class="footer-col">
                    <h4>Contact Information</h4>
                    <ul class="contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Fitness Street, New York, NY 10001</li>
                        <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-envelope"></i> info@smartgym.com</li>
                        <li><i class="fas fa-clock"></i> Mon-Sun: 24/7</li>
                    </ul>
                    <!-- Social Media Icons (Instagram, YouTube, Facebook) -->
                    <div class="social-links">
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="#about"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="membership-plans.php"><i class="fas fa-chevron-right"></i> Membership Plans</a></li>
                        <li><a href="trainers.php"><i class="fas fa-chevron-right"></i> Trainers</a></li>
                        <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>

                <!-- Column 3: Location Map -->
                <div class="footer-col">
                    <h4>Find Us</h4>
                    <div class="map-container">
                        <!-- Google Maps Embed (example location) -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.9663095343008!2d-73.98510768458418!3d40.74856997932781!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" allowfullscreen="" loading="lazy" title="Gym Location"></iframe>
                    </div>
                </div>

                <!-- Column 4: Social & Copyright Preview (or extra info) -->
                <div class="footer-col">
                    <h4>Connect With Us</h4>
                    <p>Follow us on social media for updates, fitness tips, and community events.</p>
                    <!-- duplicate social for clarity but we already have above -->
                </div>
            </div>

            <!-- Copyright Section -->
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Smart Gym Management System. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Scripts (unchanged functionality, except testimonials data) -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 800, easing: 'ease-in-out', once: true, mirror: false });

            const preloader = document.getElementById('preloader');
            setTimeout(() => { preloader.classList.add('fade-out'); }, 500);

            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) navbar.classList.add('scrolled');
                else navbar.classList.remove('scrolled');
            });

            const hamburger = document.querySelector('.hamburger');
            const navMenu = document.querySelector('.nav-menu');
            if (hamburger) {
                hamburger.addEventListener('click', () => {
                    hamburger.classList.toggle('active');
                    navMenu.classList.toggle('active');
                    const spans = hamburger.querySelectorAll('span');
                    if (hamburger.classList.contains('active')) {
                        spans[0].style.transform = 'rotate(45deg) translate(5px, 6px)';
                        spans[1].style.opacity = '0';
                        spans[2].style.transform = 'rotate(-45deg) translate(7px, -8px)';
                    } else {
                        spans[0].style.transform = 'none';
                        spans[1].style.opacity = '1';
                        spans[2].style.transform = 'none';
                    }
                });
            }

            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    if (hamburger) {
                        hamburger.classList.remove('active');
                        navMenu.classList.remove('active');
                        const spans = hamburger.querySelectorAll('span');
                        spans[0].style.transform = 'none';
                        spans[1].style.opacity = '1';
                        spans[2].style.transform = 'none';
                    }
                });
            });

            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('.nav-menu a');
            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (window.scrollY >= sectionTop - 200) current = section.getAttribute('id');
                });
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${current}`) link.classList.add('active');
                });
            });

            const counters = document.querySelectorAll('.stat-number');
            const speed = 200;
            const animateCounter = (counter) => {
                const target = parseInt(counter.getAttribute('data-target'));
                const count = parseInt(counter.innerText);
                const increment = target / speed;
                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(() => animateCounter(counter), 1);
                } else {
                    counter.innerText = target;
                }
            };
            const observerOptions = { threshold: 0.5, rootMargin: '0px' };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counters = entry.target.querySelectorAll('.stat-number');
                        counters.forEach(counter => {
                            if (counter.innerText === '0') animateCounter(counter);
                        });
                    }
                });
            }, observerOptions);
            const heroStats = document.querySelector('.hero-stats');
            if (heroStats) observer.observe(heroStats);

            const backToTop = document.getElementById('backToTop');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 500) backToTop.classList.add('show');
                else backToTop.classList.remove('show');
            });
            if (backToTop) {
                backToTop.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            const testimonials = [
                { name: 'Sarah Johnson', role: 'Member since 2023', image: 'https://randomuser.me/api/portraits/women/44.jpg', text: 'The QR code attendance system is amazing! No more waiting in line to check in. The trainer panel helped me track my progress effectively.' },
                { name: 'Mike Chen', role: 'Member since 2024', image: 'https://randomuser.me/api/portraits/men/45.jpg', text: 'Best gym management system I\'ve used. The online payment feature is seamless and the workout plans are personalized.' },
                { name: 'Emily Rodriguez', role: 'Member since 2023', image: 'https://randomuser.me/api/portraits/women/46.jpg', text: 'I love how easy it is to track my attendance and payments. The admin dashboard gives me great insights into my progress.' }
            ];
            const testimonialsSlider = document.getElementById('testimonials-slider');
            let currentTestimonial = 0;
            function showTestimonial(index) {
                const testimonial = testimonials[index];
                const testimonialHTML = `
                    <div class="testimonial-card" data-aos="fade-up">
                        <div class="testimonial-content">
                            <i class="fas fa-quote-left"></i>
                            <p>${testimonial.text}</p>
                            <div class="testimonial-author">
                                <img src="${testimonial.image}" alt="${testimonial.name}" loading="lazy">
                                <div>
                                    <h4>${testimonial.name}</h4>
                                    <span>${testimonial.role}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                if (testimonialsSlider) testimonialsSlider.innerHTML = testimonialHTML;
            }
            if (testimonialsSlider) {
                showTestimonial(0);
                setInterval(() => {
                    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
                    showTestimonial(currentTestimonial);
                }, 5000);
            }

            window.addEventListener('resize', () => {
                if (window.innerWidth > 768 && hamburger) {
                    hamburger.classList.remove('active');
                    navMenu.classList.remove('active');
                    const spans = hamburger.querySelectorAll('span');
                    spans[0].style.transform = 'none';
                    spans[1].style.opacity = '1';
                    spans[2].style.transform = 'none';
                }
            });
        });
    </script>
</body>
</html>