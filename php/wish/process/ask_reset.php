<?php
if (isset($_POST['username']) AND $_POST['username']) {
    $thisUsername = $_POST['username'];
    $getUser = $bdd->prepare("SELECT users.id, users.surname, users.email FROM users WHERE users.username = :thisUsername");
    $getUser->bindParam(':thisUsername', $thisUsername);
    $getUser->execute();
    if ($getUser->rowCount() > 0) {
        $user = $getUser->fetch(PDO::FETCH_OBJ);

        // generate unique link
        $linkid = issueLinkId($user->id, $thisUsername, $bdd);
        if (!empty($linkid)) {
            debug("New link has been created");
            send_reset_mail($user->surname, $user->email, $linkid, $bdd);

            $clientMessage = "Un mail vient de vous être envoyé, contenant les instructions de réinitialisation de votre mot de passe.";
        } else {
            debug("Unable to reset password : unable to log link");
            $clientMessage = "Une erreur technique est survenue.";
        }
    } else {
        debug("Unable to reset password : wrong username");
        $clientMessage = "Pas de login, pas de réinitialisation !";
    }
} else {
    debug("Unable to reset password : no username");
    $clientMessage = "Pas de login, pas de réinitialisation !";
}

?>