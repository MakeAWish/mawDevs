<?php
if (isset($_POST['p']) AND $_POST['p'] AND $_POST['p'] != ""
    AND isset($_POST['new_p']) AND $_POST['new_p'] AND $_POST['new_p'] != ""
        AND isset($_POST['userid']) AND $_POST['userid'] AND $_POST['userid'] != ""
            AND isset($_GET['linkid']) AND $_GET['linkid']
) {
    // Verify that the passwords are the same (control has be done in JS, but better makes sure)
    $userId = $_POST['userid'];
    $linkid = $_GET['linkid'];
    $getUser = $bdd->prepare("SELECT users.username FROM users
                                    INNER JOIN login_reset ON users.id = login_reset.user_id
                                    WHERE linkid = :linkId AND users.id = :thisUser ");
    $getUser->bindParam(':thisUser', $userId);
    $getUser->bindParam(':linkId', $linkid);
    $getUser->execute();
    if ($getUser->rowCount() > 0) {

        $username = $getUser->fetch(PDO::FETCH_OBJ)->username;
        $p1 = $_POST['p'];
        $p2 = $_POST['new_p'];

        if ($p1 == $p2) {
            // Create a random salt
            $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            // Create salted password (Careful not to over season)
            $new_password = hash('sha512', $p1 . $random_salt);
            debug('new password : ' . $new_password);
            $passwordChanged = resetPassword($username, $new_password, $random_salt, $bdd);
            if (!$passwordChanged) {
                debug("Profile modified, but not the password : wrong password");
                $clientMessage = "Une erreur est survenue, votre mot de passe n'a pas été modifié";
            } else {
                $clientMessage = "Votre mot de passe a été mis à jour !";
            }
        } else {
            debug("Password reset fail : not the same password");
            $clientMessage = "Une erreur est survenue, votre mot de passe n'a pas été modifié";
        }
    } else {
        debug("Password reset fail : user does not match the link");
        $clientMessage = "Une erreur est survenue, votre mot de passe n'a pas été modifié";
    }
} else {
    debug("Password reset fail : wrong parameters");
    $clientMessage = "Une erreur est survenue, votre mot de passe n'a pas été modifié";
}
?>