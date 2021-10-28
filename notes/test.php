<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta class="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<form action="" method="POST">
    <input type="button" value="0" class="mybutton">
    <input type="button" value="1" class="mybutton">
    <input type="button" value="2" class="mybutton">
</form>

<p id="output">Click Button</p>
<?php 
  //  if (isset($_POST["mybutton"]))
  //  {
      //  echo $_POST["mybutton"];
  //  }
?>
<script>
  const button = document.querySelectorAll('.mybutton');
  const paragraph = document.querySelector("p");

  for (let i = 0; i < button.length; i++) {
    button[i].addEventListener('click', updateButton);
    
  }

  function updateButton() {
    document.getElementById('output').innerText = "You clicked: " + this.value;
  }
</script>
<!-- <script src="script.js"></script> -->
</body>
</html>