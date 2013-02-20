<?php

include 'db_connect.php';
include 'functions.php';

sec_session_start();

if(login_check($bdd) != 1) {
   header('Location: ./?page=login&error=timeout');
}


/* Condition */
if(
	isset($_POST['name']) AND $_POST['name'] AND $_POST['name'] != "" 
	AND isset($_POST['surname']) AND $_POST['name'] AND $_POST['name'] != ""
	AND isset($_POST['email']) AND $_POST['email'] AND $_POST['email'] != ""
	AND isset($_POST['p']) AND $_POST['p'] AND $_POST['p'] != ""
	) 
{
   

/* Travail */
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['p'];
$color = $_POST['color'];
$admin = $_POST['admin'];

$queryString="INSERT INTO users(name, surname, email, idcolor, admin) 
				VALUES (:name, :surname, :email, :color, :admin)";
         $query = $bdd->prepare($queryString);
         $query->bindParam(':name', $name);
         $query->bindParam(':surname', $surname);
         $query->bindParam(':email', $email);
         $query->bindParam(':color', $color);
         $query->bindParam(':admin', $admin);

         $query->execute();

        // Create a random salt
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        // Create salted password (Careful not to over season)
        $password = hash('sha512', $password.$random_salt);

        resetPassword($email, $password, $random_salt, $bdd);


/* Conclusion */
header('Location: ./?page=create_user&add=success');
}

else {
 header('Location: ./?page=create_user&add=failure');  
}

?>
