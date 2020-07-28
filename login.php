<?php
  $password = $_POST['password'];

  if ($password == "pass") {
    session_start();
    $_SESSION['loggedin'] = true;
  }

  header('Location: index.php');
?>