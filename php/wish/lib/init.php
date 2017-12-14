<?php

require_once('params.php');
require_once('functions.php');
require_once('classes/user.php');

/*****************************/
/***** Connect to DB *********/
/*****************************/

try {
    $bdd = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$clientMessage = "";
$debugMessages = array();
?>