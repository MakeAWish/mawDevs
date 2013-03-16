<script type="text/javascript" src="script/wishlist.js" ></script>

<?php
    // S'il y a une action à faire (ediction, suppression, ajout, on la fait)
    if(isset($_POST['action'])){
        include 'process/'.$_POST['action'].'.php';
    }
?>

<!-- Code de la page -->
<section class="content">
<?php

    $my_id=$_SESSION['user_id'];
    $showEdit = true;
    $useridforfilter = $my_id;

    if(isset($_GET['user']) and ($_GET['user'] != $my_id)) {
        $useridforfilter = $_GET['user'] ;
        $showEdit = false;
    }

    try {
        $getWishesCategories = $bdd->prepare("SELECT DISTINCT categories.id, category AS name FROM wishes
                                                INNER JOIN categories ON wishes.idcategory = categories.id
                                                INNER JOIN wishlists ON wishes.idwishlist = wishlists.id
                                                INNER JOIN users ON wishlists.iduser = users.id
                                                INNER JOIN colors ON users.idcolor=colors.id
                                                LEFT JOIN gifts ON gifts.idwish = wishes.id
                                                WHERE users.id = :userid AND (gifts.offered = 0 OR gifts.offered IS NULL) AND wishes.deleted = 0
                                                ORDER BY category");
        $getWishesCategories->bindParam (':userid', $useridforfilter);
        $getWishesCategories->execute();

        while ($category = $getWishesCategories->fetch(PDO::FETCH_OBJ)) {?>
            <p class="category">
                <?php echo $category->name ?>
            </p>
           <?php

            $getWishesForCategory = $bdd->prepare("SELECT wishes.*, gifts.id as giftid, gifts.iduser AS buyerid, colors.name as colorname FROM wishes
                                        INNER JOIN categories ON wishes.idcategory = categories.id
                                        INNER JOIN wishlists ON wishes.idwishlist = wishlists.id
                                        INNER JOIN users ON wishlists.iduser = users.id
                                        INNER JOIN colors ON users.idcolor=colors.id
                                        LEFT JOIN gifts ON gifts.idwish = wishes.id
                                        WHERE users.id = :my_id AND (gifts.offered = 0 OR gifts.offered IS NULL) AND wishes.deleted = 0
                                        AND categories.id =:idcategory");
            $getWishesForCategory->bindParam(':my_id', $useridforfilter);
            $getWishesForCategory->bindParam(':idcategory', $category->id); // Bind "$email" to parameter.
            $getWishesForCategory->execute();
            ?>
            <form class="clic" method="post">
                <?php while ($wish = $getWishesForCategory->fetch(PDO::FETCH_OBJ)) {
                        $classGift = "gift";
                        $isBought = false;
                        if($wish->buyerid != null)    {
                            $classGift = "bought";
                            $isBought = true;
                        }

                        if ($showEdit == false) { ?>
                            <div class="<?php echo $classGift ?> non_exclusive">
                                <?php if($isBought == false) { ?>
                                    <input type="checkbox" name="gift" value="<?php echo $wish->id ?>"/>
                                <?php } ?>
                        <?php } else { ?>
                            <div class="<?php echo $classGift ?> exclusive">
                                <?php if($isBought == false) { ?>
                                    <input type="radio" name="gift" value="<?php echo $wish->id ?>"/>
                                <?php } ?>
                        <?php } ?>

                                <span class="icon <?php echo $wish->colorname ?>"><!-- --></span>
                                <div class="gift_descr">
                                    <span class="gift_title"><?php echo $wish->title ?></span>
                                    <p><?php echo $wish->description ?></p>
                                </div>

                                <?php if($wish->link!="") { ?>
                                    <a target="_blank" title="Suivez le lien !" href="<?php echo $wish->link ?>">
                                        <div class="follow_link"></div>
                                    </a>
                                <?php } ?>
                                <?php if($isBought== true && $showEdit == true) { ?>
                                    <input type="hidden" name="giftId" value="<?php echo $wish->giftid ?>" />
                                    <input type="submit" value="" class="offered" title="Cadeau reçu"/>
                                <?php } ?>
                            </div>
                <?php } ?>
            </form>
        <?php } ?>
    </section>

    <?php if ($showEdit) { ?>
        <section class="submit_3">
            <input class="add" type="submit" value="" title="Ajouter"/>
            <input class="edit" type="submit" value="" title="Modifier"/>
            <input class="delete" type="submit" value="" title="Supprimer"/>
        </section>
    <?php } else { ?>
        <section class="submit_1">
            <input class="validate offer" type="submit" value="" title="Offrir !"/>
        </section>
    <?php }
    }
    catch (PDOException $e)
    {
        echo 'Erreur : ' . $e->getMessage();
    }
?>