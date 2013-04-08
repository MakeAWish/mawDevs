<?php
if (isset($_POST['data']) AND $_POST['data']) {
    $wish_id = $_POST['data'];
    $currentUserId = $_SESSION['user_id'];

    $queryString = "UPDATE wishes SET wishes.deleted = 1
            WHERE id IN (
                SELECT * FROM (
                    SELECT wishes.id FROM wishes
                    INNER JOIN wishlists ON wishes.idwishlist = wishlists.id
                    WHERE wishlists.iduser = :userid AND  wishes.id = :wish_id
                ) AS Q
            )";
    $query = $bdd->prepare($queryString);
    $query->bindParam(':wish_id', $wish_id);
    $query->bindParam(':userid', $currentUserId);
    $query->execute();
    if ($query->rowCount() > 0) {
        $clientMessage = "Voeu supprimé !";
    } else {
        debug("Unable to delete wish : wrong user");
        $clientMessage = "Désolé, mais vous n'avez pas le droit de supprimer ce voeu.";
    }
} else {
    debug("Unable to delete wish : no wish id");
    $clientMessage = "Désolé, un problème technique est survenu. Votre voeu n'a pas été supprimé.";
}
?>
