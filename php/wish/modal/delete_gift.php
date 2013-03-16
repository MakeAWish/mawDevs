<?php
    // Connect to DB
    include 'init.php';
    // Control User Rights and Status
    include 'control_login.php';

    if(isset($_POST['data']) AND $_POST['data']) {
        $giftsIds = $_POST['data'];
        $isPlural = strpos($giftsIds, ",") ? true : false;

        $getGifts = $bdd->prepare("SELECT title FROM wishes
                                    INNER JOIN gifts ON gifts.idwish = wishes.id
                                    WHERE gifts.id IN ($giftsIds)");
        $getGifts->execute();
        ?>
        <form method="post">
            <h1 class="typein">Ne plus offrir <?php echo $isPlural ? "ces cadeaux" : "ce cadeau" ?> : </h1>
            <section class="typein">
                <input type="hidden" name="data" value="<?php echo $giftsIds ?>"/>
                <?php
                while ($giftTitle = $getGifts->fetch(PDO::FETCH_OBJ)) {?>
                    <h2><?php echo $giftTitle->title ?></h2>
                <?php } ?>
            </section>

            <section class="submit_2">
                <input type="hidden" name="action" value="delete_gift"/>
                <input class="validate" type="submit" value="" title="Valider"/>
                <span title="Annuler" class="cancel popin-close"><!-- --></span>
            </section>
        </form>
    <?php }
?>