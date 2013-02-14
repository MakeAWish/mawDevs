<?php if(isset($_POST['gift']) AND $_POST['gift']) {
    $gift = $_POST['gift'];
    $isPlural = strpos($gift, ",") ? true : false;

    $queryString="SELECT id, title, link, description FROM wishes
                WHERE id IN ($gift)";
            $query = $bdd->prepare($queryString);
            $query->execute();
?>
<form action="#" method="post">
    <h1 class="typein">Supprimer <?php echo $isPlural ? "ces cadeaux" : "ce cadeau" ?> : </h1>
    <section class="typein">
        <input type="hidden" name="gift" value="<?php echo $gift?>"/>
        <?php
        while ($ligne = $query->fetch()) {
            extract($ligne);?>
            <h2><?php echo $title ?></h2>
        <?php } ?>
    </section>

    <section class="submit_2">
        <input type="hidden" name="page" value="process_delete_gift"/>
        <input class="validate" type="submit" value="" title="Valider"/>
        <span title="Annuler" class="cancel popin-close"><!-- --></span>
        <span class="close popin-close"><!-- --></span>
    </section>
</form>

<?php
}?>