<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>PHP: User Authentication System - Login</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
<div class="registration-form">
    <form action="" method="post">
        <div class="form-icon">
            <span><i class="icon icon-user"></i></span>
        </div>
        <div class="form-group">
            <input type="text" class="form-control item" name="username" id="username" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="password" class="form-control item" name="password" id="password" placeholder="Password">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-block submit" name="login" id="login">Login</button>
        </div>
    </form>
    <div class="alternate">
        <h5>Don't have an account?</h5>
        <div class="option">
            <a href="signup.php">Create Account</a>
        </div>
    </div>
</div>
</body>
</html>


