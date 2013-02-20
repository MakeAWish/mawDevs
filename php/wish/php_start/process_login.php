<?php

include 'db_connect.php';
include 'functions.php';

sec_session_start(); // Our custom secure way of starting a php session.

if(isset($_POST['username'], $_POST['p'])) {
   $v = $_POST['username'];
   $password = $_POST['p']; // The hashed password.

   $atempts_login = login($v, $password, $bdd);
   if($atempts_login == "ok") {
      // Login success
      header('Location: ./?page=wishlist&login=success');
   } else {
      // Login failed
      header('Location: ./?page=login&error='.$atempts_login);
   }
} else {
   // The correct POST variables were not sent to this page.
   echo 'Invalid Request';
}

?>