<div class="nav_2">
    <?php
    if (isset($isAdmin) && $isAdmin == 1) {
        ?>
        <a href="?page=admin">Admin</a> |
    <?php } ?>
    <a href="?page=logout">Déconnexion</a>
</div>

<header>
    <?php echo "* Make a Wish";
    try {
        $user_id = $_SESSION['user_id'];
        $getUser = $bdd->prepare("SELECT users.surname FROM users WHERE users.id = :thisUser ");
        $getUser->bindParam(':thisUser', $user_id);
        $getUser->execute();
        $user = $getUser->fetch(PDO::FETCH_OBJ);
        if (!empty($user->surname)) {
            echo ", <span>" . $user->surname . "</span>";
        }
        echo " *";
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }?>
</header>

<?php
$menu = array(
    "wishlist" => "Ma Wishlist",
    "gift" => "Faire un cadeau",
    "giftlist" => "Ma Giftlist",
    "profile" => "Mon Profil"
);

$page = null;
if (isset($_GET['page']) AND $_GET['page'] == 'wishlist' AND isset($_GET['user'])) {
    $page = "gift";
} else {
    $page = $_GET['page'];
}?>
<nav id="nav">
    <ul>
        <?php foreach ($menu as $key => $value) { ?>
            <li>
                <a <?php if ($page == $key) {
                    echo 'class="active"';
                }?> href="?page=<?php echo $key ?>">
                    <?php echo $value ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>