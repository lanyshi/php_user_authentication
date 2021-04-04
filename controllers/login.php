<?php
// Database connection
include('config/db.php');

global $wrongPwdErr, $accountNotExistErr, $email_empty_err, $pass_empty_err;

if(isset($_POST['login'])) {
    $email_login = $_POST['email'];
    $password_login = $_POST['password'];

    // clean data
    $user_email = mysqli_real_escape_string($connection, $email_login);
    $pswd = mysqli_real_escape_string($connection, $password_login);

    // validate data
    $user_email_valid = filter_var($user_email, FILTER_SANITIZE_EMAIL);

    if(!empty($email_login) && !empty($password_login)) {
        // Query if email exists in db
        $sql = "SELECT * From users WHERE email = '{$user_email}' ";
        $query = mysqli_query($connection, $sql);
        $rowCount = mysqli_num_rows($query) or die("SQL query failed: " . mysqli_error($connection));

        // Check if email exist
        if($rowCount <= 0) {
            $accountNotExistErr = '<div class="alert alert-danger">
                        The email does not exist.
                    </div>';
        } else {

            // Fetch user data and store in php session
            while ($row = mysqli_fetch_array($query)) {
                $id = $row['id'];
                $pswd_hash = $row['password']; // Hashed password
            }
            // Verify password
            if(password_verify($password_login, $pswd_hash)) {
                header("Location: home.php");

                $_SESSION['id'] = $id;
                $_SESSION['email'] = $email_login;

            } else {
                $wrongPwdErr = '<div class="alert alert-danger">
                                Password is incorrect. Try again.
                            </div>';
            }
        }
    } else {
        if(empty($email_login)) {
            $email_empty_err = '<div class="alert alert-danger">
                                Please enter Email.
                            </div>';
        }
        if(empty($password_login)) {
            $pass_empty_err = '<div class="alert alert-danger">
                                Please enter Password.
                            </div>';
        }
    }

}

?>
