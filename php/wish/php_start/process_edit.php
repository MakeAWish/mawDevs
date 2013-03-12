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
$category = $_POST['category'];
$title = $_POST['title'];
$link = $_POST['link'];
$description = $_POST['description'];
$gift = $_POST['gift'];
$my_id=$_SESSION['user_id'];

$queryString="UPDATE wishes, wishlists SET wishes.idcategory = :category, wishes.title = :title, wishes.link = :link, wishes.description = :description WHERE wishes.id = :gift AND wishes.idwishlist = wishlists.id AND wishlists.iduser = :userid";
         $query = $bdd->prepare($queryString);
         $query->bindParam(':title', $title);
         $query->bindParam(':category', $category);
         $query->bindParam(':link', $link);
         $query->bindParam(':description', $description);
         $query->bindParam(':gift', $gift);
         $query->bindParam(':userid', $my_id);

         $query->execute();


/* Conclusion */
header('Location: ./?page=wishlist&edit=success');
}

else {
 header('Location: ./?page=wishlist&edit=failure&cause=title');  
}

?>
