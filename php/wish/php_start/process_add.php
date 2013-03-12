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
$my_id=$_SESSION['user_id'];

$queryString="INSERT INTO wishes(idwishlist, idcategory, title, link, description) 
   SELECT id, :category, :title, :link, :description FROM `wishlists` 
   WHERE iduser=:iduser";
         $query = $bdd->prepare($queryString);
         $query->bindParam(':iduser', $my_id);
         $query->bindParam(':category', $category);
         $query->bindParam(':title', $title);
         $query->bindParam(':link', $link);
         $query->bindParam(':description', $description);

         $query->execute();


/* Conclusion */
header('Location: ./?page=wishlist&add=success');
}

else {
 header('Location: ./?page=wishlist&add=failure&cause=title');  
}

?>
