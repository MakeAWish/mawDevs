<script type="text/javascript" src="script/wishlist.js"></script>

<?php
// S'il y a une action à faire (ediction, suppression, ajout, on la fait)
if (isset($_POST['action'])) {
    include 'process/' . $_POST['action'] . '.php';
}
?>

<!-- Code de la page -->
<section class="content">
    <?php

    $my_id = $_SESSION['user_id'];
    $showEdit = true;
    $helpMessage = "Si vous en avez saisi, vous verrez ici la liste de vos voeux";
    $useridforfilter = $my_id;

    if (isset($_GET['user']) and ($_GET['user'] != $my_id)) {
        $useridforfilter = $_GET['user'];
        $showEdit = false;
        $receiver = new User($useridforfilter);
        $helpMessage = "Voici la liste des cadeaux que vous pouvez faire à $receiver->surname";
    }

    try {
        $categoriesOfWishes = bdd_getCategoriesOfWishes($bdd, $useridforfilter);?>

    <form class="clic" method="post" data-step="3" data-position="top" data-intro="<?php echo $helpMessage ?>">
        <?php
        foreach($categoriesOfWishes as &$category) {?>
        <p class="category">
            <?php echo $category->name ?>
        </p>
        <?php
        $getWishesOfUserForCategory  = bdd_getWishesOfUserForCategory($bdd, $useridforfilter, $category->id);
        foreach($getWishesOfUserForCategory as &$wish) {
            $classGift = "gift";
            $isBought = false;
            if ($wish->buyerid != null) {
                $classGift = "bought";
                $isBought = true;
        }

        if ($showEdit == false) { ?>
        <div class="<?php echo $classGift ?> non_exclusive">
            <?php if ($isBought == false) { ?>
                <input type="checkbox" name="gift" value="<?php echo $wish->id ?>"/>
            <?php } ?>
            <?php } else { ?>
            <div class="<?php echo $classGift ?> exclusive">
                <?php if ($isBought == false) { ?>
                    <input type="radio" name="gift" value="<?php echo $wish->id ?>"/>
                <?php } ?>
                <?php } ?>

                <span class="icon <?php echo $wish->colorname ?>"><!-- --></span>

                <div class="gift_descr">
                    <span class="gift_title"><?php echo $wish->title ?></span>

                    <p><?php echo $wish->description ?></p>
                </div>

                <?php if ($wish->link != "") { ?>
                    <a target="_blank" title="Suivez le lien !" href="<?php echo $wish->link ?>">
                        <div class="follow_link"></div>
                    </a>
                <?php } ?>
                <?php if ($isBought == true && $showEdit == true) { ?>
                    <input type="hidden" name="giftId" value="<?php echo $wish->giftid ?>"/>
                    <input type="submit" value="" class="offered" title="Cadeau reçu"/>
                <?php } ?>
            </div>
            <?php }
            } ?>
    </form>
</section>

<?php if ($showEdit) { ?>
    <section class="submit_3" data-step="4" data-position="top" data-intro="Vous pouvez ajouter un voeu en cliquant sur Ajouter. Pour modifier un voeu, cliquez d'abord sur le voeu, puis sur Modifier ou Supprimer">
        <input class="add" type="submit" value="" title="Ajouter"/>
        <input class="edit" type="submit" value="" title="Modifier"/>
        <input class="delete" type="submit" value="" title="Supprimer"/>
    </section>
<?php } else { ?>
    <section class="submit_1" data-step="4" data-position="top" data-intro="Pour signaler que vous souhaitez offrir un ou plusieurs cadeaux, cliquez sur ce(s) cadeau(x) puis sur Valider">
        <input class="validate offer" type="submit" value="" title="Offrir !"/>
    </section>
<?php
}
}
catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>