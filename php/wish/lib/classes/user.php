<?php
require_once('color.php');
require_once('wishlist.php');

class User {
    // Eléments de notre panier
    public $id,
        $username,
        $surname,
        $email,
        $color,
        $wishlists;
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

        $this->wishlists = array();
        $bdd_wishlists = bdd_getWishlists($bdd, $id);
        foreach($bdd_wishlists as &$bdd_wishlist) {
            $wishlist = new Wishlist($bdd_wishlist->id);
            if(count($wishlist->wishes) > 0) {
                array_push($this->wishlists, $wishlist);
            }
        }
    }
}
?>