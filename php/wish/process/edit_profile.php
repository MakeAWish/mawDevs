<?php
if (isset($_POST['surname']) AND $_POST['surname'] AND $_POST['surname'] != ""
    AND isset($_POST['email']) AND $_POST['email'] AND $_POST['email'] != ""
) {

    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $color = $_POST['color'];
    $my_id = $_SESSION['user_id'];

    $query = $bdd->prepare("UPDATE users
                                SET users.surname = :surname, users.email = :email, users.idcolor = :color
                                WHERE users.id = :userid");
    $query->bindParam(':surname', $surname);
    $query->bindParam(':email', $email);
    $query->bindParam(':color', $color);
    $query->bindParam(':userid', $my_id);
    $query->execute();

    if ($query->rowCount() > 0) {
        $clientMessage = "Votre profil a été modifié !";
    } else {
        debug("Unable to edit profile : wrong user");
        $clientMessage = "Désolé, mais vous n'avez pas le droit de modifier ce profil.";
    }

    if (isset($_POST['p']) AND $_POST['p'] AND $_POST['p'] != ""
        AND isset($_POST['new_p']) AND $_POST['new_p'] AND $_POST['new_p'] != ""
    ) {

        // Verify that the password is legit
        $v = $_POST['username'];
        $password = $_POST['p']; // The hashed password.

        $atempts_login = login($v, $password, $bdd);
        debug("atempts login : " . $atempts_login);
        if ($atempts_login == "ok") {
            $new_password = $_POST['new_p'];
            // Create a random salt
            $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            // Create salted password (Careful not to over season)
            $new_password = hash('sha512', $new_password . $random_salt);

            debug('new password : ' . $new_password);
            $passwordChanged = resetPassword($v, $new_password, $random_salt, $bdd);
            if (!$passwordChanged) {
                debug("Profile modified, but not the password : wrong password");
                $clientMessage = "Votre profil a été mis à jour mais pas votre mot de passe";
            } else {
                $clientMessage = "Votre profil et votre mot de passe ont été mis à jour ! Par contre, on va sûrement vous demander de vous reconnecter...";
            }
        } else {
            debug("Profile modified, but not the password : wrong password");
            $clientMessage = "Votre profil a été mis à jour mais pas votre mot de passe, car le mot de passe actuel saisi était erroné.";
        }
    } else {
        $clientMessage = "Votre profil a été mis à jour !";
    }
} else {
    debug("Unable to edit profil : some parameters are missing");
    $clientMessage = "Il manquait des paramètres, votre profil n'a pas pu être mis à jour.";
}
?>