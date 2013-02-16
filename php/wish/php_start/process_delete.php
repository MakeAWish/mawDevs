<?php

include 'db_connect.php';
include 'functions.php';

sec_session_start();

if(login_check($bdd) != 1) {
   header('Location: ./?page=login&error=timeout');
}


/* Condition */
if(isset($_POST['gift']) AND $_POST['gift']) {
   

/* Travail */
$gift = $_POST['gift'];
$my_id=$_SESSION['user_id'];

$queryString="UPDATE wishes SET wishes.deleted = 1  
WHERE id IN (
		SELECT * FROM ( 
			SELECT wishes.id FROM wishes 
			INNER JOIN wishlists ON wishes.idwishlist = wishlists.id 
			WHERE wishlists.iduser = :userid AND  wishes.id = :gift
		) AS Q 
	)";
$query = $bdd->prepare($queryString);
$query->bindParam(':gift', $gift);
$query->bindParam(':userid', $my_id);
$query->execute();


/* Conclusion */
header('Location: ./?page=wishlist&delete=success');
}

else {
 header('Location: ./?page=wishlist&delete=failure&cause=title');  
}

?>
