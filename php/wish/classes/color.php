<?php
class Color {
    // Eléments de notre panier
    public $id,
        $name;

    // Ajout de $num articles de type $artnr au panier

    function __construct($id) {
        global $bdd;
        $baseColor = bdd_getColor($bdd, $id);
        $this->id = $baseColor->id;
        $this->name = $baseColor->name;
    }
}
?>