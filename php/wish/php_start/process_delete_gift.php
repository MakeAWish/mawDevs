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

/*
$queryString="DELETE INTO gifts(iduser, idwish)
                SELECT :iduser, id FROM wishes
                WHERE id IN ($gift)";
         $query = $bdd->prepare($queryString);
         $query->bindParam(':iduser', $my_id);

         $query->execute();
*/

    header('Location: ./?page=giftlist');
}

else {
 header('Location: ./?page=giftlist&delete_gift=failure&cause=nogifts');
}

?>