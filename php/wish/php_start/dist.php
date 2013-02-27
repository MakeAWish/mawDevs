<?php

include 'db_connect.php';
include 'functions.php';

sec_session_start();

if(login_check($bdd) != 1) {
   header('Location: ./?page=login&error=timeout');
}

$my_id=$_SESSION['user_id'];
$queryString="SELECT admin as isAdmin FROM users
                WHERE users.id = :user_id";
$query = $bdd->prepare($queryString);
$query->bindParam(':user_id', $my_id);
$query->execute();
$ligne = $query->fetch();
extract($ligne);

if(isset($_GET['page']) AND $_GET['page'] == "admin" AND $isAdmin != 1) {
    header('Location: ./?page=logout');
}

?>