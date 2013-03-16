<?php
    if(isset($_POST['data']) AND $_POST['data']) {
        $wish_id = $_POST['data'];
        if(isset($_POST['title']) AND $_POST['title'] != "") {
            $category = $_POST['category'];
            $title = $_POST['title'];
            $link = $_POST['link'];
            $description = $_POST['description'];
            $currentUserId=$_SESSION['user_id'];

            $queryString="UPDATE wishes, wishlists
                            SET wishes.idcategory = :category, wishes.title = :title, wishes.link = :link, wishes.description = :description
                            WHERE wishes.id = :wish_id AND wishes.idwishlist = wishlists.id AND wishlists.iduser = :userid";
            $query = $bdd->prepare($queryString);
            $query->bindParam(':title', $title);
            $query->bindParam(':category', $category);
            $query->bindParam(':link', $link);
            $query->bindParam(':description', $description);
            $query->bindParam(':wish_id', $wish_id);
            $query->bindParam(':userid', $currentUserId);
            $query->execute();
            if($query->rowCount() > 0){
                $clientMessage = "Voeu modifié !";
            } else {
                debug("Unable to edit wish : wrong user");
                $clientMessage = "Désolé, mais vous n'avez pas le droit de modifier ce voeu.";
            }
        } else {
            debug("Edit wish failed : no title");
            $clientMessage = "Il faut au moins garder un titre ! Votre voeu n'a pas été modifié.";
        }
    } else {
        debug("Unable to edit wish : no wish id");
        $clientMessage = "Désolé, un problème technique est survenu. Votre voeu n'a pas été modifié.";
    }
?>
