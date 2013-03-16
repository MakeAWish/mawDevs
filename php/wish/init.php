<?php

include 'functions.php';

/*****************************/
/***** Connect to DB *********/
/*****************************/

define("HOST", "localhost"); // The host you want to connect to.
define("USER", "maw_user"); // The database username.
define("PASSWORD", "7R34OMg4RT3836Y"); // The database password.
define("DATABASE", "makeawish"); // The database name.

try {
    $bdd = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USER, PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$clientMessage = "";
$debugMessages = array();
?>