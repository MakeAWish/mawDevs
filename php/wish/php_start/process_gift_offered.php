<?php

include 'db_connect.php';
include 'functions.php';

sec_session_start();

if(login_check($bdd) != 1) {
   header('Location: ./?page=login&error=timeout');
}


/* Condition */
if(isset($_POST['gift']) AND $_POST['gift'] AND $_POST['gift'] != "") {
   

/* Travail */
$gift = $_POST['gift'];
$my_id=$_SESSION['user_id'];

$queryString="UPDATE gifts SET gifts.offered = 1 WHERE gifts.idwish = :gift";
         $query = $bdd->prepare($queryString);
         $query->bindParam(':gift', $gift);
         $query->execute();


/* Conclusion */
header('Location: ./?page=wishlist&offered=success');
}

else {
 header('Location: ./?page=wishlist&offered=failure&cause=gift');  
}

?>
