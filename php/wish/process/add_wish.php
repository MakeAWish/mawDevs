<?php

if (isset($_POST['title']) AND $_POST['title'] != "") {
    $category = $_POST['category'];
    $title = $_POST['title'];
    $link = $_POST['link'];
    $description = $_POST['description'];
    $currentUserId = $_SESSION['user_id'];

    $queryString = "INSERT INTO wishes(idwishlist, idcategory, title, link, description)
                  SELECT id, :category, :title, :link, :description FROM `wishlists`
                  WHERE iduser=:iduser";
    $query = $bdd->prepare($queryString);
    $query->bindParam(':iduser', $currentUserId);
    $query->bindParam(':category', $category);
    $query->bindParam(':title', $title);
    $query->bindParam(':link', $link);
    $query->bindParam(':description', $description);
    $query->execute();
    if ($query->rowCount() > 0) {
        $clientMessage = "Voeu ajouté !";
    } else {
        debug("Unable to edit wish : wish already exists");
        $clientMessage = "Ce voeu existe déjà !";
    }
} else {
    debug("Add wish failed : no title");
    $clientMessage = "Pas de titre, pas de cadeau !";
}?>
