<?php
    if(    isset($_POST['username']) AND $_POST['username'] AND $_POST['username'] != ""
        AND isset($_POST['surname']) AND $_POST['surname'] AND $_POST['surname'] != ""
        AND isset($_POST['email']) AND $_POST['email'] AND $_POST['email'] != ""
        AND isset($_POST['p']) AND $_POST['p'] AND $_POST['p'] != "" ) {

        $username = $_POST['username'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['p'];
        $color = $_POST['color'];
        $admin = $_POST['admin'];

        /*******************
         ** Creation User **
         *******************/

        $queryString="INSERT INTO users(username, surname, email, idcolor, admin)
                        VALUES (:username, :surname, :email, :color, :admin)";
        $query = $bdd->prepare($queryString);
        $query->bindParam(':username', $username);
        $query->bindParam(':surname', $surname);
        $query->bindParam(':email', $email);
        $query->bindParam(':color', $color);
        $query->bindParam(':admin', $admin);
        $query->execute();

        /**********************************
         ** Creation Wishlist par défaut **
         **********************************/

        $queryString="INSERT INTO wishlists(iduser)
                        SELECT id FROM users
                        WHERE username = :username";
        $query = $bdd->prepare($queryString);
        $query->bindParam(':username', $username);
        $query->execute();

        /************************************
         ** Initialisation du mot de passe **
         ************************************/

        // Create a random salt
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        // Create salted password (Careful not to over season)
        $password = hash('sha512', $password.$random_salt);
        resetPassword($username, $password, $random_salt, $bdd);

        /* Conclusion */
        $clientMessage = "Le profil a été créé !";
    }
    else {
        debug("Unable to create user : wrong parameters");
        $clientMessage = "Désolé, un problème technique est survenu. Le profil n'a pas été créé.";
    }
?>