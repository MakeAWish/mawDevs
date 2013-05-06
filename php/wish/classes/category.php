<?php
class Category {
    // Eléments de notre panier
    public $id,
        $name;

    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();

        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

    function __constuct0() {
        $this->name = "Unknown";
    }

    function __construct1($id) {
        global $bdd;
        $bdd_category = bdd_getCategory($bdd, $id);
        $this::initialize($bdd_category);
    }

    public function initialize($bdd_category) {
        $this->id = $bdd_category->id;
        $this->name = $bdd_category->name;
    }
}
?>