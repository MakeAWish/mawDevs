<?php

include 'db_connect.php';
include 'functions.php';

sec_session_start();

if(login_check($bdd) != 1) {
   header('Location: ./?page=login&error=timeout');
}


/* Condition */
if(isset($_POST['surname']) AND $_POST['surname'] AND $_POST['surname'] != ""
    AND isset($_POST['email']) AND $_POST['email'] AND $_POST['email'] != "") {

    /* Travail */
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $color = $_POST['color'];
    $my_id=$_SESSION['user_id'];

    $queryString="UPDATE users SET users.surname = :surname, users.email = :email, users.idcolor = :color WHERE users.id = :userid";
             $query = $bdd->prepare($queryString);
             $query->bindParam(':surname', $surname);
             $query->bindParam(':email', $email);
             $query->bindParam(':color', $color);
             $query->bindParam(':userid', $my_id);

             $query->execute();

    if(isset($_POST['p']) AND $_POST['p'] AND $_POST['p'] != ""
        AND isset($_POST['new_p']) AND $_POST['new_p'] AND $_POST['new_p'] != "") {

        // Verify that the password is legit
       $v = $_POST['username'];
       $password = $_POST['p']; // The hashed password.

       $atempts_login = login($v, $password, $bdd);
       echo "atempts login : ".$atempts_login;
       if($atempts_login == "ok") {
            $new_password = $_POST['new_p'];
            // Create a random salt
            $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            // Create salted password (Careful not to over season)
            $new_password = hash('sha512', $new_password.$random_salt);

            echo 'new password : '.$new_password;
            $passwordChanged = resetPassword($v, $new_password, $random_salt, $bdd);
            if (!$passwordChanged){
                header('Location: ./?page=profile&edit=success&password=unchanged&cause=unknown');
            }
            else
            {
                header('Location: ./?page=profile&edit=success&password=changed');
            }
        }
        else
        {
            header('Location: ./?page=profile&edit=success&password=unchanged&cause=wrong');
        }

    }
    else
    {
        header('Location: ./?page=profile&edit=success');
    }
}
else {
    header('Location: ./?page=profile&edit=failure');
}

?>
