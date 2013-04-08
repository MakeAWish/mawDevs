<?php
// Connect to DB
include 'init.php';
// Control User Rights and Status
include 'control_login.php';

if (isset($_POST['data']) AND $_POST['data']) {
    $wishesIds = $_POST['data'];
    $isPlural = strpos($wishesIds, ",") ? true : false;

    $getGifts = $bdd->prepare("SELECT id, title, link, description FROM wishes
                                    WHERE id IN ($wishesIds)");
    $getGifts->execute();
    ?>
    <form method="post">
        <h1 class="typein">Offrir <?php echo $isPlural ? "ces cadeaux" : "ce cadeau" ?> : </h1>
        <section class="typein">
            <input type="hidden" name="data" value="<?php echo $wishesIds ?>"/>
            <?php
            while ($gift = $getGifts->fetch(PDO::FETCH_OBJ)) {
                ?>
                <h2><?php echo $gift->title ?></h2>
            <?php } ?>
        </section>

        <section class="submit_2">
            <input type="hidden" name="action" value="make_gift"/>
            <input class="validate" type="submit" value="" title="Valider"/>
            <span title="Annuler" class="cancel popin-close"><!-- --></span>
        </section>
    </form>
<?php } ?>