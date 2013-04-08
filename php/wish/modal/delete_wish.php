<?php
// Connect to DB
include 'init.php';
// Control User Rights and Status
include 'control_login.php';

if (isset($_POST['data']) AND $_POST['data']) {
    $wish_id = $_POST['data'];

    $getWish = $bdd->prepare("SELECT title, link, description, idcategory AS wishcategoryid FROM wishes
                                    WHERE wishes.id = :wish_id
                                    ORDER BY wishes.id DESC LIMIT 0,1");
    $getWish->bindParam(':wish_id', $wish_id);
    $getWish->execute();
    $wish = $getWish->fetch(PDO::FETCH_OBJ);
    ?>
    <form method="post">
        <h1 class="typein">Supprimer ce souhait ? </h1>
        <section class="typein">
            <input type="hidden" name="data" value="<?php echo $wish_id ?>"/>

            <h2><?php echo $wish->title ?></h2>
        </section>

        <section class="submit_2">
            <input type="hidden" name="action" value="delete_wish"/>
            <input class="validate" type="submit" value="" title="Valider"/>
            <span title="Annuler" class="cancel popin-close"><!-- --></span>
        </section>
    </form>

<?php
}?>