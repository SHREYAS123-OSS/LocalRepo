<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Smart Gym · Admin Signup</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Inter',sans-serif;
}

body{
background:#0a0a0a;
height:100vh;
display:flex;
align-items:center;
justify-content:center;
}

/* Card */

.signup-container{
background:#111;
border:1px solid #1f1f1f;
padding:40px;
width:380px;
border-radius:12px;
}

.signup-container h2{
color:white;
font-weight:500;
margin-bottom:25px;
font-size:22px;
}

/* Inputs */

.signup-container input{
width:100%;
padding:12px;
margin-bottom:14px;
background:#0a0a0a;
border:1px solid #1f1f1f;
border-radius:6px;
color:white;
font-size:14px;
transition:0.2s;
}

.signup-container input:focus{
outline:none;
border-color:#ff3c00;
}

/* Button */

.primary-btn{
width:100%;
padding:12px;
background:#ff3c00;
border:none;
border-radius:6px;
color:white;
font-size:14px;
cursor:pointer;
transition:0.2s;
}

.primary-btn:hover{
background:#ff5722;
}

/* Login Link */

.login-link{
margin-top:18px;
font-size:13px;
color:#888;
text-align:center;
}

.login-link a{
color:#ff3c00;
text-decoration:none;
}

.login-link a:hover{
text-decoration:underline;
}

</style>
</head>

<body>

<div class="signup-container">

<h2>Create Admin Account</h2>

<form action="../Backend/signup_process.php" method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="email" name="email" placeholder="Email Address" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" class="primary-btn">
Register Admin
</button>

</form>

<div class="login-link">
Already have an account? 
<a href="login.php">Login</a>
</div>

</div>

</body>
</html>