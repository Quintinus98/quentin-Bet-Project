<?php

session_start();

//check if user is logged in otherwise, redirect to login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}


include("config/db_connect.php");


// function to get random value
function get_random(){
  return rand(1, 25);
}

// Initialize some variables 
$guess = 0;
$state_text = "";
$message = "";
$wallet = 100;
$email = $_SESSION['email'];


$wallet_sql = "SELECT TOP 1 email, wallet FROM users ORDER BY id DESC";
$result_wallet = mysqli_query($conn, $wallet_sql);

printf ($result_wallet);
// if(mysqli_num_rows($result_wallet) > 0) {
//   $row = mysqli_fetch_assoc($result_wallet);
//   $wallet = $row['wallet'];
// }

// evaluate condition and go ahead.
if (isset($_POST['confirm'])) {
  
  // if ($table_val !== false) {
  //   // table exists

  // } else {
    $sql = "CREATE TABLE IF NOT EXISTS users (
      id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      email VARCHAR(50) NOT NULL,
      guess INT(6),
      computerValue INT(6),
      state_text VARCHAR(50) NOT NULL,
      stake INT(6),
      gain_loss INT(6),
      wallet INT(6),
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
      
    // if ($conn->query($sql) === TRUE) {
    //   echo "Table users created successfully";
    // } else {
    //   echo "Error creating table - users: " . $conn->error;
    // }
    
  // }


  // --------------------------------------------
  $guess = (int)$_POST["confirm"];
  $computerVal = get_random();

  // check if the user's selection is correct
  if ($guess == 0){
    $state_text = "Invalid Number!";
  }else{
    $message = ("Computer generated value: $computerVal") ;
    $message .= nl2br("\nYour selection: $guess");
    if ($computerVal == $guess) {
      $state_text = "You win";
    } else {
      $state_text = "You Lose";
    }
  }

  // Get stake from form
  $stake = (int)$_POST['stake'];

  if ($state_text == "You win") {
    $gain_loss = $stake * 7;
  } else {
    $gain_loss = $stake * (-1);
  }
  $wallet += $gain_loss;
  // --------------------------------------------

  $query = "INSERT INTO users (email, guess, computerValue, state_text, stake, gain_loss, wallet) VALUES ('$email','$guess', '$computerVal', '$state_text', '$stake', '$gain_loss', '$wallet')";
  
  $conn->query($query);


  //  

  // if ($conn->query($query)===TRUE){
  //   echo "New record created successfully";
  // } else {
  //   echo "Error: ". $query . "<br>". $conn->error;
  // }


 $conn -> close();

}






?>

 <!-- start of Html file  -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="dashboard.css">
  <!-- Boxicons CDN Link  -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <title>Dashboard</title>
</head>
<body>
  <div class="sidebar">
    <div class="logo_content">
      <div class="logo">
        <div class="logo_name">StarnetBet</div>
      </div>
      <i class='bx bx-menu' id="btn"></i>
    </div><hr>
    <ul class="nav_list accordion" id="sidebarExample">

      <!-- Home  -->
      <li>
        <i class='bx bx-log-out'></i>
        <span class="tooltip">Log out</span>
        <a data-toggle="collapse" href="#collapseHome" role="button" aria-expanded="false" aria-controls="collapseHome" id="homeinput">
          <span class="links_name">Log out</span>
        </a>  
      </li>
      <div class="collapse" id="collapseHome" data-parent="#sidebarExample">
        <div class="card bg-light m-3 p-2 lead border-0 text-size" style="font-size: 14px;">You will be re-directed to the Login page <code><a href="logout.php" style="text-decoration: none;"> Continue to Login Page</a></code></div>
      </div>
      

      <!-- Dashboard  -->
      <li>
        <i class='bx bxs-contact' ></i>
        <span class="tooltip">Dashboard</span>
        <a data-toggle="collapse" href="#collapseDashboard" role="button" aria-expanded="false" aria-controls="collapseDashboard">
          <span class="links_name">Dashboard</span>
        </a> 
      </li>
      <div class="collapse" id="collapseDashboard" data-parent="#sidebarExample">
        <div class="card bg-light m-3 p-2 border-0">
          <label class="form-label h2 text-center" for="wallet">My Wallet</label>
          <input class="form-control" type="text" name="wallet" id="wallet" value="<?php echo htmlspecialchars($wallet); ?>" disabled>
        </div>
      </div>


      <!-- How to Play -->
      <li>
        <i class='bx bx-dice-6' ></i>
        <span class="tooltip">How to play</span>
        <a data-toggle="collapse" href="#collapseHowToPlay" role="button" aria-expanded="false" aria-controls="collapseHowToPlay">
          <span class="links_name">How to Play</span>
        </a> 
      </li>
      <div class="collapse" id="collapseHowToPlay" data-parent="#sidebarExample">
        <div class="card bg-light m-3 p-2 lead border-0" style="font-size: 14px;">
          Select a number from the options provided
          <div class="list-unstyled text-muted">
            <p>Confirm your selected number. Every win you make multiplies your earnings 7 times.</p>
            <p>Good luck!</p>
          </div>
        </div>
      </div>
    

      <!-- Fund My Wallet  -->
      <li>
        <i class='bx bxs-bank' ></i>
        <span class="tooltip">Fund My Wallet</span>
        <a data-toggle="collapse" href="#collapseFundWallet" role="button" aria-expanded="false" aria-controls="collapseFundWallet">
          <span class="links_name">Fund My Wallet</span>
        </a> 
      </li>
      <div class="collapse" id="collapseFundWallet" data-parent="#sidebarExample">
        <div class="card bg-light m-3 p-2 lead border-0" style="font-size: 14px;">
          Some code is going in here
        </div>
      </div>



      <!-- Contact  -->
      <li>
        <i class='bx bx-id-card'></i>
        <span class="tooltip">Contact Us</span>
        <a data-toggle="collapse" href="#collapseContactUs" role="button" aria-expanded="false" aria-controls="collapseContactUs">
          <span class="links_name">Contact Us</span>
        </a> 
      </li>
      <div class="collapse" id="collapseContactUs" data-parent="#sidebarExample">
        <div class="card bg-light m-3 p-2 lead border-0 accordion-body border-pill" style="font-size: 14px;">

          <!-- form sends action to itself -->
          <form action="#" method="post">
            <!-- email  -->
            <div class="my-4 input-group">
              <span class="input-group-text pe-2"><i class='bx bx-envelope'></i>
              <input type="email" name="email" id="email" class="form-control" placeholder="e.g. starnet@example.com" style="font-size: 13px;"></span>
            </div>
            <!-- Query --> 
            <div class="form-floating my-2" style="font-size: 13px;">
              <label for="query">Enter your question...</label>
              <textarea class="form-control" name="query" id="query" style="height: 70px;"></textarea>
            </div>

            <!-- button button  -->
            <div class="text-center">
              <button type="submit" class="btn btn-success">Get answers</button>
            </div>
          </form>



        </div>
      </div>


    </ul>
  </div>

  <div class="home_content bg-light">
    <div class="py-2 px-3 justify-content-center">
      <div class="mt-2 text-center bg-info py-2 border border-dark border-3 text-light">
        <p class="text-center font-monospace py-2">This is the game console. You are one step away from being a $ millioniare</p>
        <p class="text-center py-2">Select a number to play</p>
      </div>


      <div class="row justify-content-left p-3">
        
        <div class="col-lg-9 grid_container justify-content-center mb-3" >
          <div class="grid-item"><input type="button" value="01" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="02" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="03" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="04" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="05" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="06" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="07" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="08" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="09" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="10" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="11" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="12" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="13" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="14" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="15" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="16" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="17" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="18" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="19" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="20" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="21" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="22" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="23" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="24" class="btn btn-outline-success"></div>
          <div class="grid-item"><input type="button" value="25" class="btn btn-outline-success"></div>
        </div>

        <!-- Confirmation form/button  -->
        <div class="col-lg-3 text-center bg-info py-3 border border-dark border-3 text-light mb-2">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="stake">Stake: </label>
            <input type="number" min="0" max="<?php echo $wallet; ?>" name="stake" id="stake" required>
            <br>
            <label for="confirm">Click the number to confirm</label>
            <input type="submit" id="output" name="confirm" class="btn btn-success" value="00">
          </form>

          <div>
            <hr>
            <?php 
            echo $message ; 
            // if ($message !== "Invalid Number!") {
              echo "<br>". $state_text;
            // }            
            ?>
            <hr>
          </div>

        </div>



      </div>
    </div>
     
  


    



    






  </div>









  <script>
    const button = document.querySelectorAll('.btn');

    for (let i = 0; i < button.length; i++) {
      button[i].addEventListener('click', updateButton);
    }

    function updateButton() {
      document.getElementById('output').value = this.value;
    }
  </script>
  <script src="script.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



</body>
</html>