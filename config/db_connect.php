<?php

  define("DB_SERVER", "localhost");
  define("DB_USERNAME", "david");
  define("DB_PASSWORD", "password");
  define("DB_NAME", "betnow_database");

  // Attempt to connect to MySQL database 
  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

  // check connection
  if (!$link) {
    die("Error: Failed to connect. " . mysqli_connect_error());
    # code...
  }
?>