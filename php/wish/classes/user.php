<?php
require_once('color.php');

class User {
    // Eléments de notre panier
    public $id,
        $username,
        $surname,
        $email,
        $color;
    private $isAdmin = 0;

    // Ajout de $num articles de type $artnr au panier

    function __construct($id) {
        global $bdd;
        $baseUser = bdd_getUser($bdd, $id);
        $this->id = $baseUser->id;
        $this->username= $baseUser->username;
        $this->surname= $baseUser->surname;
        $this->email= $baseUser->email;
        $idcolor = $baseUser->idcolor;
        $this->color= new Color($idcolor);
    }
}
?>