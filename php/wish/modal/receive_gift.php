<?php
// Connect to DB
include 'init.php';
// Control User Rights and Status
include 'control_login.php';

if (isset($_POST['data']) AND $_POST['data']) {
    $giftId = $_POST['data'];

    $getWish = $bdd->prepare("SELECT title FROM wishes
                                    INNER JOIN gifts ON gifts.idwish = wishes.id
                                    WHERE gifts.id = :giftId
                                    ORDER BY wishes.id DESC LIMIT 0,1");
    $getWish->bindParam(':giftId', $giftId);
    $getWish->execute();
    $wishTitle = $getWish->fetch(PDO::FETCH_OBJ);
    ?>
    <form method="post">
        <h1 class="typein">Confirmer la réception ? *</h1>
        <section class="typein">
            <input type="hidden" name="data" value="<?php echo $giftId ?>"/>

            <h2><?php echo $wishTitle->title ?></h2>
        </section>

        <section class="submit_2">
            <input type="hidden" name="action" value="receive_gift"/>
            <input class="validate" type="submit" value="" title="Valider"/>
            <span title="Annuler" class="cancel popin-close"><!-- --></span>
        </section>
        <p class="asterisque">* Alors, heureux ?</p>
    </form>
<?php } ?>