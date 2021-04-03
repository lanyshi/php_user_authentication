<?php

// Database connection
include('config/db.php');

// Error & success messages
global $success_msg, $email_exist, $username_exist, $_usernameErr, $_emailErr, $_passwordErr;
global $usernameEmptyErr, $emailEmptyErr, $passwordEmptyErr;

// Set empty form vars for validation mapping
$_username = $_email = $_password = "";

if(isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // check if username already exists
    $username_check_query = mysqli_query($connection, "SELECT * FROM users WHERE username = '{$username}' ");
    $userRowCount = mysqli_num_rows($username_check_query);

    // check if email already exists
    $email_check_query = mysqli_query($connection, "SELECT * FROM users WHERE email = '{$email}' ");
    $emailRowCount = mysqli_num_rows($email_check_query);

    // PHP validation
    // Verify if form values are not empty
    if(!empty($username) && !empty($email) && !empty($password)){
        // check if username already exist
        if($userRowCount > 0) {
            $username_exist = '
                <div class="alert alert-danger" role="alert">
                    Username already exists.
                </div>';
        }
        elseif ($emailRowCount > 0) {
            $email_exist = '
                <div class="alert alert-danger" role="alert">
                    Email has already been registered.
                </div>';
        }
        else {
            // clean the form data before sending to database
            $_username = mysqli_real_escape_string($connection, $username);
            $_email = mysqli_real_escape_string($connection, $email);
            $_password = mysqli_real_escape_string($connection, $password);

            // perform validation
            $username_valid = preg_match("/^[a-z\d_]{5,20}$/i", $_username);
            $email_valid = filter_var($_email, FILTER_VALIDATE_EMAIL);
            $password_valid = preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z]{8,20}$/", $_password);

            if(!$username_valid) {
                $_usernameErr = '
                    <div class="alert alert-danger">
                        Username should only contain alphabet, number, underscore, and has 5 to 20 characters.
                    </div>';
            }
            if(!$email_valid) {
                $_emailErr = '<div class="alert alert-danger">
                            Email format is invalid.
                        </div>';
            }
            if(!$password_valid) {
                $_passwordErr = '<div class="alert alert-danger">
                             Password should be between 8 to 20 characters, contains at least one lowercase, uppercase and a digit.
                        </div>';
            }

            if($username_valid && $email_valid && $password_valid) {
                // Password hash
                $password_hash = password_hash($password, PASSWORD_BCRYPT);

                // Query
                $sql = "INSERT INTO users (username, email, password, date_time) VALUES (
                        '{$username}', '{$email}', AES_ENCRYPT('{$password}', 'passw'), now())";

                // Create mysql query
                $sqlQuery = mysqli_query($connection, $sql);

                if(!$sqlQuery){
                    die("MySQL query failed!" . mysqli_error($connection));
                }
                else {
                    header("Location: registration_success.php");
                }
            }
        }
    }
    else {
        if(empty($username)) {
            $usernameEmptyErr = '<div class="alert alert-danger">
                    Username can\'t be blank.
                </div>';
        }
        if(empty($email)) {
            $emailEmptyErr = '<div class="alert alert-danger">
                    Email can\'t be blank.
                </div>';
        }
        if(empty($password)) {
            $passwordEmptyErr = '<div class="alert alert-danger">
                    Password can\'t be blank.
                </div>';
        }
    }
}
?>