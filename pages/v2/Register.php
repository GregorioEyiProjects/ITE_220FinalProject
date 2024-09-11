<?php
    session_start();
    
    include '../../DB/db_connection.php';  

    // Initialize variables
    $username = null;
    $gmail = null;
    $password = null;
    $submit = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $gmail = isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $submit = isset($_POST['submit']) ? $_POST['submit'] : null;
        
        if ($submit) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $result = register_user($username, $gmail, $hashed_password);
            $rertrieve_users_hashed_password = getStoredHashedPassword($username);
            if ($result) {
                
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $gmail; 
                $_SESSION['user_hashed_password'] = $rertrieve_users_hashed_password; 
                header("Location: HomePage.php");
                //header("Location: HomePage.php?username=" . urlencode($username));
                exit(); // Always exit after a header redirect
            }
        }
    }
                        
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Styles/V2/loging_and_register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Register</title>
</head>
<body>
    
    <div class="form-container">
        <h2>Register</h2>
        <form action="#" method="post" class="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email (Gmail):</label>
                <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
            </div>
            <div class="form-group password-container">
                <label for="password">Password:</label>
                <input class="password-input" type="password" id="password" name="password" required>
                <span class="password-toggle-icon">
                    <i onclick="hideAndShow()" class="fas fa-eye" id="password-toggle-icon"></i>
                </span>
            </div>

            <div class="have-an-account-container">
                <p class="have-an-account-text"> Have an account already?
                    <a class="have-an-account-link" href="Login.php">Login</a>
                </p>
            </div>

            <div  class="form-btn-submit">
                <input name="submit" class="btn-register" type="submit" value="Register">
            </div>
        </form>
    </div>

    <script src="../../JS/V2/register.js"></script>
</body>
</html>