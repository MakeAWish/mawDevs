<?php

include 'db_connect.php';
include 'functions.php';

sec_session_start();

if(login_check($bdd) != 1) {
   header('Location: ./?page=login&error=timeout');
}


/* Condition */
if(isset($_POST['surname']) AND $_POST['surname'] AND $_POST['surname'] != "" AND isset($_POST['email']) AND $_POST['email'] AND $_POST['email'] != "") {
   

/* Travail */
$surname = $_POST['surname'];
$email = $_POST['email'];
$color = $_POST['color'];
$my_id=$_SESSION['user_id'];

$queryString="UPDATE users SET users.surname = :surname, users.email = :email, users.idcolor = :color WHERE users.id = :userid";
         $query = $bdd->prepare($queryString);
         $query->bindParam(':surname', $surname);
         $query->bindParam(':email', $email);
         $query->bindParam(':color', $color);
         $query->bindParam(':userid', $my_id);

         $query->execute();



/* Conclusion */
header('Location: ./?page=profile&edit=success');
}

else {
 header('Location: ./?page=profile&edit=failure&cause=empty');  
}

?>
