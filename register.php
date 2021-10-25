<?php

include('config/db_connect.php');



$first_name = $email = $last_name = $username = $password = "";
$errors = array('email'=>"", 'first_name'=>"", 'last_name'=>"", 'username'=>"", 'password'=>"");
// check
if(isset($_POST['submit'])){
    
    // email 
    if (empty($_POST['email'])){
        $errors['email'] = 'An email is required';
    }else{
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Email must be a valid email address';
        }
    }

    // firstname 
    if (empty($_POST['first_name'])){
        $errors['first_name'] = 'A first_name is required';
    }else{
        $first_name = $_POST['first_name'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $first_name)){
            $errors['first_name'] = 'first_name must be letters and spaces only';
        }
    }

    // lastname 
    if (empty($_POST['last_name'])){
        $errors['last_name'] = 'A last_name is required';
    }else{
        $last_name = $_POST['last_name'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $last_name)){
            $errors['last_name'] = 'last_name must be letters and spaces only';
        }
    }

    // Username 
    if (empty($_POST['username'])){
        $errors['username'] = 'Please enter a username';
    }else{
        $username = $_POST['username'];
        if(!preg_match('/^[a-zA-Z0-9_]+$/', $username)){
            $errors['username'] =  'Username can only contain letters, numbers, and underscores.';
        }else {
          $sql = "SELECT id FROM users WHERE username = ?";
          if($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $_POST["username"];

            if (mysqli_stmt_execute($stmt)) {
              // store result
              mysqli_stmt_store_result($stmt);
              if (mysqli_stmt_num_rows($stmt) == 1) {
                $errors["username"] = "This username is already taken";
              }
            } else {
              echo "Hmm! Some error has occured. Try again.";
            }
          }
        }
    }


    // Password
    
    
    // form is without errors
    if(!array_filter($errors)){

        // protecting data going into the database - mysqli_real_escape_string
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);

        $sql = "INSERT INTO pizzas(first_name, email, last_name) VALUES('$first_name', '$email', '$last_name')";
        //save to db and check
        if (mysqli_query($conn, $sql)){
            header('Location: index.php');
        }else {
            echo 'query error: '.mysqli_error($conn);
        }

    }

} // end of POST check








?>