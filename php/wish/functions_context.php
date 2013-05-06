<?php

function currentUser()
{
    if(!in_array('currentUser', $GLOBALS)) {
        debug('Fetch current user');
        $GLOBALS['currentUser'] = new User($_SESSION['user_id']);
    }

    return $GLOBALS['currentUser'];
}

function availableColors()
{
    global $bdd;

    if(!in_array('colors', $GLOBALS)) {
        debug('Fetch available colors');

        $colors = array();
        $bdd_colors = bdd_getColors($bdd);
        foreach($bdd_colors as &$bdd_color) {
            $color = new Color();
            $color::initialize($bdd_color);
            array_push($colors, $color);
        }
        $GLOBALS['colors'] = $colors;
    }
    return $GLOBALS['colors'];
}

function availableCategories()
{
    global $bdd;

    if(!in_array('categories', $GLOBALS)) {
        debug('Fetch available categories');

        $categories = array();
        $bdd_categories = bdd_getCategories($bdd);
        foreach($bdd_categories as &$bdd_category) {
            $category = new Category();
            $category->initialize($bdd_category);
            array_push($categories, $category);
        }
        $GLOBALS['categories'] = $categories;
    }
    return $GLOBALS['categories'];
}

?>