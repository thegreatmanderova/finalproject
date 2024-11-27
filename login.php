<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">

    <title>ProFolio</title>
</head>
<body>

 <div class="wrapper">

    <div class="content">
        <h1><span>Pro</span>Folio</h1>
        <p class="tagline">Showcase Your Skills,<br>Elevate Your Career</p>
    </div>

    <nav class="nav">
        <div class="nav-logo">
            <p><span id="pro">Pro</span>Folio</p>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="login()">Sign In</button>
            <button class="btn" id="registerBtn" onclick="register()">Sign Up</button>
        </div>
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>

    <div class="box_form">
        <div class="login-container" id="login">
            <div class="top">
                <span>Don't have an account? <a href="#" onclick="register()">Sign Up</a></span>
                <header>Sign In</header>
            </div>

            <form action="login_process.php" method="POST">
            <div class="input-box">
                <input type="text" name="email" class="input-field" placeholder="Email">
                <i class="bx bx-user"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" class="input-field" placeholder="Password">
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="submit" class="submit" value="Sign In">
            </div>
        </div>
</form>

        <div class="register-container" id="register">
            <div class="top">
                <span>Have an account? <a href="#" onclick="login()">Login</a></span>
                <header>Sign Up</header>
            </div>

            <form action="signup_process.php" method="POST">
            <div class="two-forms">
                <div class="input-box">
                    <input type="text" name="name" class="input-field" placeholder="Full Name">
                    <i class="bx bx-user"></i>
                </div>
            </div>
            <div class="input-box">
                <input type="text" name="email" class="input-field" placeholder="Email">
                <i class="bx bx-envelope"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" class="input-field" placeholder="Password">
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="submit" class="submit" value="Register">
            </div>
        </div>
</form>
    </div>
</div>   

<footer>
    <p>&copy; 2024 ProFolio. All rights reserved.</p>
</footer>

<script src="loginAndSignUp.js"></script>

</body>
</html>