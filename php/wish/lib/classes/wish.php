<?php
require_once('category.php');

class Wish {
    // Eléments de notre panier
    public $id,
        $title,
        $link,
        $description,
        $category,
        $reserved,
        $offered,
        $buyer_id;

    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

    function __constuct0() {

    }

    function __construct1($id) {
        global $bdd;
        $bdd_wish = bdd_getWish($bdd, $id);
        $this->initialize($bdd_wish);
    }

    public function initialize($bdd_wish) {
        $this->id = $bdd_wish->id;
        $this->title = $bdd_wish->title;
        $this->link = $bdd_wish->link;
        $this->description = $bdd_wish->description;
        $this->reserved = ($bdd_wish->reserved == 1);
        $this->offered = ($bdd_wish->offered == 1);
        if($this->offered OR $this->reserved) {
            $this->buyer_id = $bdd_wish->buyer_id;
        }

        $idcategory = $bdd_wish->idcategory;
        $this->category= new Category($idcategory);
    }
}
?>