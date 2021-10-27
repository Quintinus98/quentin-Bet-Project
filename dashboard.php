<?php

session_start();

//check if user is logged in otherwise, redirect to login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}


?>


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
          <input class="form-control" type="text" name="wallet" id="wallet" disabled>
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
          <ul class="list-unstyled text-muted">
            <li>Content 1</li>
            <li>Content 2</li>
          </ul>
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
          <form action="#index.html" method="post">
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

            <!-- submit button  -->
            <div class="text-center">
              <button type="submit" class="btn btn-success">Get answers</button>
            </div>
          </form>



        </div>
      </div>


    </ul>
  </div>

  <div class="home_content justify-content-center">

    <div class="p-2 ">
      <p class="text-center font-monospace px-3">This is the game console. You are one step away from being a $ millioniare</p>     
      <div class="grid_container p-5 justify-content-center ">
        <div class="grid-item"><button class="btn btn-outline-success">01</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">02</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">03</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">04</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">05</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">06</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">07</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">08</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">09</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">10</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">11</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">12</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">13</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">14</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">15</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">16</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">17</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">18</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">19</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">20</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">21</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">22</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">23</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">24</button></div>
        <div class="grid-item"><button class="btn btn-outline-success">25</button></div>
        <div class="grid-item"><button type="submit"  value="30" class="btn btn-outline-success">30</button></div>
      </div>
    </div>
     


  </div>










  
  <script src="script.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



</body>
</html>