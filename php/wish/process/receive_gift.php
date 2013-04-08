<?php
if (isset($_POST['data']) AND $_POST['data']) {
    $giftsIds = $_POST['data'];
    $currentUserId = $_SESSION['user_id'];

    $query = $bdd->prepare("UPDATE gifts, wishes, wishlists
                                SET gifts.offered = 1
                                WHERE gifts.id IN ($giftsIds) AND gifts.idwish = wishes.id
                                AND wishes.idwishlist = wishlists.id AND wishlists.iduser = :userid");
    $query->bindParam(':userid', $currentUserId);
    $query->execute();
    if ($query->rowCount() > 0) {
        $clientMessage = "Ce cadeau a été marqué comme offert !";
    } else {
        debug("Unable to offer gift : wrong user");
        $clientMessage = "Désolé, mais vous n'avez pas le droit de modifier ce cadeau.";
    }
} else {
    debug("Unable to offer gift : no gift id");
    $clientMessage = "Désolé, un problème technique est survenu. Votre cadeau n'a pas été marqué comme reçu.";
}
?>