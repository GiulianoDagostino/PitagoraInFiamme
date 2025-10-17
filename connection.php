
<?php
  $servername = "localhost:3306";
  $username = "giuliano";
  $password = "prepuzio";
  $db = "barche";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $db);

  // Check connection
  if (!$conn)
  {
    die("Connection failed: " . mysqli_connect_error($conn));
  }
  else
  {
    $sql = "";
  }
?>


