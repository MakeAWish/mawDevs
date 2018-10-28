<?php
if (isset($_POST['data']) AND $_POST['data']) {
    $giftsIds = $_POST['data'];
    $currentUserId = $_SESSION['user_id'];

    $query = $bdd->prepare("DELETE FROM gifts
                                WHERE idwish IN ($giftsIds) AND iduser = :userid");
    $query->bindParam(':userid', $currentUserId);
    $query->execute();
    if ($query->rowCount() > 0) {
        $clientMessage = "Ok, bien enregistré ! Ces cadeaux sont désormais disponibles pour que d'autres les offrent !";
    } else {
        debug("Unable to delete gift : wrong user");
        $clientMessage = "Désolé, mais vous n'avez pas le droit de supprimer ce cadeau.";
    }
} else {
    debug("Unable to delete gifts : no gift id");
    $clientMessage = "Désolé, un problème technique est survenu. Votre voeu n'a pas été supprimé.";
}
?>