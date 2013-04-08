<?php
if (isset($_POST['data']) AND $_POST['data']) {
    $wishesIds = $_POST['data'];
    $my_id = $_SESSION['user_id'];

    $query = $bdd->prepare("INSERT IGNORE INTO gifts(iduser, idwish)
                                SELECT :iduser, id FROM wishes
                                WHERE id IN ($wishesIds)");
    $query->bindParam(':iduser', $my_id);
    $query->execute();
    if ($query->rowCount() > 0) {
        $clientMessage = "Cela va faire un heureux !";
    } else {
        debug("Unable to make gift : no wishes");
        $clientMessage = "Désolé, mais vous n'avez pas été assez rapide : ce voeu est déjà acheté !";
    }
} else {
    debug("Unable to make gifts : no gifts id");
    $clientMessage = "Désolé, un problème technique est survenu. Ce cadeau ne sera pas considéré comme offert.";
}
?>