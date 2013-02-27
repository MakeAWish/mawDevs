<?php
$surname = null;
try {
    $user_id=$_SESSION['user_id'];
    $queryString="SELECT users.surname FROM users WHERE users.id = :thisUser ";
    $query = $bdd->prepare($queryString);
    $query->bindParam(':thisUser', $user_id);
    $query->execute();
    $ligne = $query->fetch();
    extract($ligne); ?>

    <?php }
    catch (PDOException $e)
    {
        echo 'Erreur : ' . $e->getMessage();
    }
?>

<div class="nav_2">
<a href="?page=logout">Déconnexion</a>


<?php 
$my_id=$_SESSION['user_id'];
$queryString="SELECT admin FROM users 
                WHERE users.id = :user_id";
            $query = $bdd->prepare($queryString);
            $query->bindParam(':user_id', $my_id);
            $query->execute();
            $ligne = $query->fetch();
            extract($ligne);

if ($admin == 1) { ?>
    |
    <a href="?page=admin">Admin</a>
<?php
}
?>

</div>

<header>
    <?php echo "* Make a Wish";
    if(!empty($surname))
    {
        echo ", <span>".$surname."</span>";
    }
    echo " *"; ?>
</header>

<?php
$menu = array(
    "wishlist" => "Ma Wishlist",
    "gift" => "Faire un cadeau",
    "giftlist" => "Ma Giftlist",
    "profile" => "Mon Profil",
); 

$active = null;
if(isset($_GET['page'])) {
    $active = $_GET['page'];
}
?>
<nav id="nav">
	<ul>
		<?php foreach ($menu as $key => $value) { ?>
            <li><a <?php if($active==$key){ echo 'class="active"'; }?> href="?page=<?php echo $key ?>"><?php echo $value ?></a></li>
        <?php } ?>
	</ul>
</nav>