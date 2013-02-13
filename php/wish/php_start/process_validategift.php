<?php

include 'db_connect.php';
include 'functions.php';

sec_session_start();

if(login_check($bdd) != 1) {
   header('Location: ./?page=login&error=timeout');
}


/* Condition */
if(isset($_POST['title']) AND $_POST['title'] AND $_POST['title'] != "") {
   

/* Travail */
$gift = $_POST['gift'];
$my_id=$_SESSION['user_id'];

$queryString="INSERT INTO gifts(iduser, idwish) VALUES (:iduser, :idwish)";
         $query = $bdd->prepare($queryString);
         $query->bindParam(':iduser', $my_id);
         $query->bindParam(':idwish', $gift);

         $query->execute();


$queryString2="SELECT users.id FROM users 
	INNER JOIN wishlists on users.id = wishlists.iduser 
	INNER JOIN wishes on wishes.idwishlist = wishlists.id
	WHERE wishes.id = :wish_id
	ORDER BY users.id LIMIT 0,1";
	$query = $bdd->prepare($queryString2);
    $query->bindParam(':wish_id', $gift);
    $query->execute();
    $ligne = $query->fetch();
    extract($ligne);

    header('Location: ./?page=wishlist&user='.$id);
}

else {
 header('Location: ./?page=wishlist&validategift=failure&cause=title');  
}

?>
