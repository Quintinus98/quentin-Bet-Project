<?php

include('config/db_connect.php');



$first_name = $email = $last_name = $username = $password = $confirm_password = "";
$errors = array('email'=>"", 'first_name'=>"", 'last_name'=>"", 'username'=>"", 'password'=>"", 'confirm_password'=>"");

// check
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
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
      $errors['first_name'] = 'A first name is required';
  }else{
      $first_name = $_POST['first_name'];
      if(!preg_match('/^[a-zA-Z\s]+$/', $first_name)){
          $errors['first_name'] = 'First name must be letters and spaces only';
      }
  }

  // lastname 
  if (empty($_POST['last_name'])){
    $errors['last_name'] = 'A last name is required';
  }else{
    $last_name = $_POST['last_name'];
    if(!preg_match('/^[a-zA-Z\s]+$/', $last_name)){
        $errors['last_name'] = 'Last name must be letters and spaces only';
    }
  }

  // Username 
  if(empty(trim($_POST["username"]))){
    $errors['username'] = "Please enter a username.";
  } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
      $errors['username'] = "Username can only contain letters, numbers, and underscores.";
  } else{
      $username = trim($_POST['username']);
  }

  // email 
  if (empty($_POST['email'])){
    $errors['email'] = 'An email is required';
  } 
  elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      $errors['email'] = 'Email must be a valid email address';
  }
  else {
    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE email = ?";
    if($stmt = mysqli_prepare($conn, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_email);
      
      // Set parameters
      $param_email = trim($_POST["email"]);
      
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
          /* store result */
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) == 1){
          $errors['email'] = 'This email is already taken.';
        } else{
          $email = trim($_POST["email"]);
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }

        // Close statement
        mysqli_stmt_close($stmt);
    }
  }

  // Password

  // check if password is empty
  if (empty(trim($_POST["password"]))) {
    $errors['password'] = "Please enter a password!";
  } 
  // if password isn't empty check the following
  elseif(!empty(trim($_POST["password"]))) {
    // first, password must be greater than 8
    $password = trim($_POST['password']);
    if (strlen(trim($_POST["password"])) < 8) {
      $errors["password"] = "Your Password Must Contain at least 8 Characters!";
    }
    elseif(!preg_match("#[0-9]+#",$password)) {
      $errors["password"] = "Your Password Must Contain at least 1 Number!";
    }
    elseif(!preg_match("#[A-Z]+#",$password)) {
      $errors["password"] = "Your Password Must Contain at least 1 Capital Letter!";
    }
    elseif(!preg_match("#[a-z]+#",$password)) {
      $errors["password"] = "Your Password Must Contain at least 1 Lowercase Letter!";
    }
  }


  // confirm Password
  if (empty(trim($_POST["confirm_password"]))) {
    $errors['confirm_password'] = "Please confirm password!";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($errors['password']) && ($password != $confirm_password)) {
      $errors["confirm_password"] = "Password did not match";
    }
  }
  
  
  // form is without errors
  if(!array_filter($errors)){

    // protecting data going into the database - mysqli_real_escape_string
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO betnow(first_name, last_name, username, email, password ) VALUES(?,?,?,?,?)";

    if($stmt = mysqli_prepare($conn, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, 'sssss', $param_first_name, $param_last_name, $param_username,$param_email, $param_password);
      
      // Set parameters
      $param_first_name = $first_name;
      $param_last_name = $last_name;
      $param_username = $username;
      $param_email = $email;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
      
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
          // Redirect to login page
          header("location: login.php");
      } else{
          echo 'Query error: '.mysqli_error($conn);
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }

  }
  // Close connection
  mysqli_close($conn);

} // end of POST check
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- userdefined css  -->
  <link rel="stylesheet" href="register.css">
  <!-- bootstrap css  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Register</title>
</head>
<body>
    
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="register_form">
      <div class="logo-container">
          <img class="logo" src="img/STARNET LOGO.jpg" alt="logo">
      </div>
      <div class="register_content">
          <div class="register_header">
              Sign Up
          </div>
          
          <!-- first_name  -->
          <input class="input_field <?php echo (!empty($errors['first_name'])) ? 'is-invalid' : ''; ?>" type="text" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($first_name) ?>" >
          <span class="invalid-feedback move_right" ><?php echo $errors['first_name']; ?></span>
          
          <!-- last_name  -->
          <input class="input_field <?php echo (!empty($errors['last_name'])) ? 'is-invalid' : ''; ?>" type="text" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($last_name) ?>" >
          <span class="invalid-feedback move_right " ><?php echo $errors['last_name']; ?></span>

          <!-- username  -->
          <input class="input_field <?php echo (!empty($errors['username'])) ? 'is-invalid' : ''; ?>" type="text" name="username" placeholder="Enter desired Username" value="<?php echo htmlspecialchars($username) ?>" >
          <span class="invalid-feedback move_right" ><?php echo $errors['username']; ?></span>

          <!-- email  -->
          <input class="input_field <?php echo (!empty($errors['email'])) ? 'is-invalid' : ''; ?>" type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email) ?>" >
          <span class="invalid-feedback move_right" ><?php echo $errors['email']; ?></span>

          <!-- password  -->
          <input class="input_field <?php echo (!empty($errors['password'])) ? 'is-invalid' : ''; ?>" type="password" name="password" placeholder="Password (8 characters or more)" value="<?php echo htmlspecialchars($password) ?>" >
          <span class="invalid-feedback move_right" ><?php echo $errors['password']; ?></span>

          <!-- confirm password  -->
          <input class="input_field <?php echo (!empty($errors['confirm_password'])) ? 'is-invalid' : ''; ?>" type="password" name="confirm_password" placeholder="Confirm Password" value="<?php echo htmlspecialchars($confirm_password) ?>" >
          <span class="invalid-feedback move_right" ><?php echo $errors['confirm_password']; ?></span>

          <!-- submit -->
          <input type="submit" value="Sign Up" class="register_button">

          <div class="other_links">
              <span class="">Already have an account? <a href="login.php">Log In</a></span> <span class="fw-bold">or</span> 
              <a href="index.html">Home</a><br>
              <p class="lead" style="font-size: 14px;">
                  By signing up, you agree to the StarnetBET <a data-bs-toggle="modal" data-bs-target="#privacypolicy" href="#privacypolicy">Service Terms & Conditions and the Privacy Policy</a>
              </p>
              
          </div>
      </div>
      
  </form>
    
  <!-- Scrollable modal -->
  <!-- Modal -->
  <div class="modal fade" id="privacypolicy" tabindex="-1" aria-labelledby="privacypolicyLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="privacypolicyLabel">Privacy Policy</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto consectetur explicabo magnam molestias voluptate porro quis nulla dolorum odio dignissimos minima illo, consequatur distinctio doloribus non illum tempore totam fuga odit eveniet minus repellat quae. Deserunt aspernatur odio nemo tenetur itaque distinctio odit a blanditiis et minus perferendis neque dolor earum libero porro, exercitationem numquam animi minima aut veniam recusandae. Labore doloremque ad animi facere illo blanditiis quaerat, cupiditate dolorem quas facilis ducimus mollitia veritatis quasi itaque porro inventore iure reprehenderit quam odio omnis est asperiores esse eveniet. Numquam ea inventore cumque qui, dolorum atque tenetur odit nesciunt iusto fugit dicta voluptates nemo sequi impedit. Obcaecati, molestias! Sunt illo atque sequi? Quasi iure distinctio illo tenetur facere placeat dolorum culpa similique, beatae provident atque quis, vel veritatis accusantium error eaque possimus tempore consequatur vero! Maiores alias magni repellendus dolore non quod optio accusamus quibusdam repellat aperiam unde soluta vero sunt fuga neque labore quaerat qui, ex recusandae aliquid nisi reprehenderit cumque quas natus. Eligendi expedita aperiam ex beatae nisi saepe quidem explicabo facilis veritatis quo asperiores placeat mollitia deleniti aliquid blanditiis sunt maiores facere, nostrum vero deserunt! In error impedit, quo molestiae voluptas aut nostrum? Non est beatae consequuntur tempore.
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
      </div>
  </div>








  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>