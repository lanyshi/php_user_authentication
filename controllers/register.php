<?php

// Database connection
include('config/db.php');

// Error & success messages
global $email_exist, $_emailErr, $_passwordErr;
global $emailEmptyErr, $passwordEmptyErr, $confirmPasswordEmptyErr, $passwordsDontMatchErr;

// Set empty form vars for validation mapping
$_email = $_password = "";

if(isset($_POST["register"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // check if email already exists
    $email_check_query = mysqli_query($connection, "SELECT * FROM users WHERE email = '{$email}' ");
    $rowCount = mysqli_num_rows($email_check_query);

    // PHP validation
    // Verify if form values are not empty
    if(!empty($email) && !empty($password) && !empty($confirmPassword)){
        // check if email already exist
        if ($rowCount > 0) {
            $email_exist = '
                <div class="alert alert-danger" role="alert">
                    Email has already been registered.
                </div>';
        } else {
            // clean the form data before sending to database
            $_email = mysqli_real_escape_string($connection, $email);
            $_password = mysqli_real_escape_string($connection, $password);
            $_confirmPassword = mysqli_real_escape_string($connection, $confirmPassword);

            // perform validation
            $email_valid = filter_var($_email, FILTER_VALIDATE_EMAIL);
            $password_valid = preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z]{8,20}$/", $_password);

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

            if($email_valid && $password_valid) {
                // Passwords hash
                $password_hash = password_hash($_password, PASSWORD_BCRYPT);

                // check password confirmation
                if(password_verify($_confirmPassword, $password_hash)) {
                    // Query
                    $sql = "INSERT INTO users (email, password, date_time) VALUES (
                        '{$_email}', '{$password_hash}', now())";

                    // Create mysql query
                    $sqlQuery = mysqli_query($connection, $sql);

                    if(!$sqlQuery){
                        die("MySQL query failed!" . mysqli_error($connection));
                    }
                    else {
                        header("Location: registration_success.php");
                    }
                } else {
                    $passwordsDontMatchErr = '<div class="alert alert-danger">
                             Passwords do not match.
                        </div>';
                }
            }
        }
    } else {
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
        if(empty($confirmPassword)) {
            $confirmPasswordEmptyErr = '<div class="alert alert-danger">
                    Please confirm password.
                </div>';
        }
    }
}
?>