<?php
try {
    $user_id=$_SESSION['user_id'];
    $queryString="SELECT users.surname FROM users WHERE users.id = :thisUser ";
    $query = $bdd->prepare($queryString);
    $query->bindParam(':thisUser', $user_id);
    $query->execute();
    $ligne = $query->fetch();
    extract($ligne); ?>

    <header>
        <?php echo "* Make a Wish";
        if(!empty($surname))
        {
            echo ", <span>".$surname."</span>";
        }
        echo " *"; ?>
    </header>

    <?php }
    catch (PDOException $e)
    {
        echo 'Erreur : ' . $e->getMessage();
    }
?>

<nav>
	<ul>
		<li><a class="active" href="?page=wishlist">Ma Wishlist</a></li>
		<li><a href="?page=gift">Faire un cadeau</a></li>
		<li><a href="?page=giftlist">Ma Giftlist</a></li>
		<li><a href="?page=logout">Déconnexion</a></li>
	</ul>
</nav>