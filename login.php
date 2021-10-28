<?php
// Start the session
session_start();

//check if logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

require_once "config/db_connect.php";

$email = $password = "";
$errors = array('email'=>"", 'password'=>"");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check email
    if (empty(trim($_POST["email"]))) {
        $errors['email'] = "Please enter your email.";
    }else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $errors['password'] = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(!array_filter($errors)){
        // Prepare a select statement
        // $sql = "SELECT id, email, password FROM betnow WHERE email = ?";
        $sql = "SELECT id, email, password FROM betnow WHERE email = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                printf("Number of rows: %d.\n", mysqli_stmt_num_rows($stmt));
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;                            
                            
                            // Redirect user to welcome page
                            header("location: dashboard.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else{
                    // email doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="login-form">
        <div class="logo-container">
            <img class="logo" src="img/STARNET LOGO.jpg" alt="logo">
        </div>
        <div class="login-content">
            <div class="login-header">Login to your Account</div>

            <!-- invalid email and password  -->
            <span>
            <?php 
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
            ?></span>


            <!-- email  -->
            <input class="input_field <?php echo (!empty($errors['email'])) ? 'is-invalid' : ''; ?>" type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email) ?>" ><span class="move_left invalid-feedback" ><?php echo $errors['email']; ?></span>


            <!-- password  -->
            <input class="input_field <?php echo (!empty($errors['password'])) ? 'is-invalid' : ''; ?>" type="password" name="password" placeholder="Password (8 characters or more)" value="<?php echo htmlspecialchars($password) ?>" >
            <span class="invalid-feedback move_left" ><?php echo $errors['password']; ?></span>

          
            <input class="login_button"   type="submit" name="submit" value="Login">


            <br><br>
            <div class="login_links">
                <a href="forgot_password.html" class="forgot_password">Forgot password?</a>
                <p class="text">or</p>
                <div class="text">
                    <a href="register.php" class="forgot_password">Sign up</a> |
                    <a href="index.html" class="forgot_password">Home</a>
                </div>
                
            </div><br>
            
    </form>
    





</body>
</html>
