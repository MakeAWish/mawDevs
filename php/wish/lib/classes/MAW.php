<?php

class MAW {

  private static $_instance = null;
  private $_colors, $_categories, $_otherUsers, $_currentUser;

  private function __construct() {
    if(false && isset($_SESSION['maw_context'])) {
        debug('Restore MAW context');
        $context = unserialize($_SESSION['maw_context']);
        $this->_colors = $context->_colors;
        $this->_categories = $context->_categories;
        $this->_otherUsers = $context->_otherUsers;
        $this->_currentUser = $context->_currentUser;
    }
  }

  private function _save() {
    debug('Save MAW context');
    $_SESSION['maw_context'] = serialize($this);
  }

  public static function getContext() {

    if(is_null(self::$_instance)) {
      self::$_instance = new MAW();
    }

    return self::$_instance;
  }

  public function getCurrentUser() {

    if(empty($this->_currentUser)){
      debug('Fetch MAW Current User');
      $this->_currentUser = new User($_SESSION['user_id']);
      $this->_save();
    }

    return $this->_currentUser;
  }

  public function getColors() {
    global $bdd;

    if(empty($this->_colors)){
      debug('Fetch MAW colors');
      $this->_colors = array();
      $bdd_colors = bdd_getColors($bdd);
      foreach($bdd_colors as &$bdd_color) {
          $color = new Color();
          $color->initialize($bdd_color);
          array_push($this->_colors, $color);
      }
      $this->_save();
    }
    return $this->_colors;
  }

  public function getOtherUsers() {
    global $bdd;

    if(empty($this->_otherUsers)){
      debug('Fetch MAW users, except current');
      $this->_otherUsers = array();
      $bdd_otherUsers = bdd_getOtherUsersIds($bdd, $_SESSION['user_id']);
      foreach($bdd_otherUsers as &$bdd_otherUser) {
          $otherUser = new User($bdd_otherUser->id);
          array_push($this->_otherUsers, $otherUser);
      }
      $this->_save();
    }
    return $this->_otherUsers;
  }

  public function getCategories() {
    global $bdd;

    if(empty($this->_categories)){
      debug('Fetch MAW categories');
      $this->_categories = array();
      $bdd_categories = bdd_getCategories($bdd);
      foreach($bdd_categories as &$bdd_category) {
          $category = new Category();
          $category->initialize($bdd_category);
          array_push($this->_categories, $category);
      }
      $this->_save();
    }

    return $this->_categories;
  }
}
?>