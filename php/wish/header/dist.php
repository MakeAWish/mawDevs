<div class="nav_2">
    <?php
    if (isset($isAdmin) && $isAdmin == 1) {
        ?>
        <a href="?page=admin">Admin</a> |
    <?php } ?>
    <span class="helpLink"><a href="javascript:void(0);" onclick="javascript:introJs().start();">Aide</a> |</span>
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
        if (!empty($user->surname)) {?>
            , <span data-step="1" data-intro="Vous êtes perdu ? Ne bougez pas, on va vous aider !"><?php echo $user->surname ?></span>
        <?php }
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

$help = array(
    "wishlist" => "Ceci est votre Wishlist, vous pouvez y ajouter tous vos voeux",
    "gift" => "D'humeur généreuse ? Vous êtes au bon endroit pour faire un cadeau",
    "giftlist" => "Si on en croit nos registres, voici les cadeaux que vous devez offrir",
    "profile" => "Ceci est votre page de profil"
>>>>>>> feature/introJs-Help
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
                    echo 'data-step="2" data-intro="'.$help[$key].'"';
                }?> href="?page=<?php echo $key ?>">
                    <?php echo $value ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>