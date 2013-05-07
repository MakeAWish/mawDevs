<?php
require_once('wish.php');

class Wishlist {
    // Eléments de notre panier
    public $id,
        $wishes;

    // Ajout de $num articles de type $artnr au panier

    function __construct($id) {
        global $bdd;
        $this->id = $id;

        $wishes = array();
        $bdd_wishes = bdd_getWishes($bdd, $id);

        foreach($bdd_wishes as &$bdd_wish) {
            $wish = new Wish();
            $wish::initialize($bdd_wish);
            array_push($wishes, $wish);
        }
    }
}
?>