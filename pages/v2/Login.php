<?php

    session_start();
    
    include '../../DB/db_connection.php';  

    // Initialize variables
    $username = null;
    $password = null;
    $submit = null;
    $error_message = null; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $submit = isset($_POST['submit']) ? $_POST['submit'] : null;
        //var_dump($username);
        //var_dump($password);
        
        if ($submit) {
            $stored_hashed_password = getStoredHashedPassword($username);
            //var_dump($stored_hashed_password);
            if($stored_hashed_password && password_verify($password, $stored_hashed_password)){
                $_SESSION['username'] = $username;
                $_SESSION['user_hashed_password'] = $stored_hashed_password;
                header("Location: HomePage.php");
                exit(); // Always exit after a header redirect
            }else{
                $error_message = "Invalid username or password.";
            }
        }else{
            echo "Invalid submit";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Styles/V2/loging_and_register.css">
    <link rel="stylesheet" href="../../Styles/V2/loging_and_register.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Login</title>
</head>
<body>
    
    <div class="form-container">
        <h2>Login</h2>
        <form action="#" method="post" class="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group password-container">
                <label for="password">Password:</label>
                <input class="password-input" type="password" id="password" name="password" required>
                <span class="password-toggle-icon">
                <i onclick="hideAndShow()" class="fas fa-eye" id="password-toggle-icon"></i>
                </span>
            </div>

            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <div class="have-an-account-container">
                <p class="have-an-account-text"> Don't have an account yet?
                    <a class="have-an-account-link" href="Register.php">Register</a>
                </p>
            </div>

            <div  class="form-btn-submit">
                <input class="btn-register" type="submit" name="submit" value="Login">
            </div>
        </form>
    </div>

    <script src="../../JS/V2/register.js"></script>
</body>
</html>

