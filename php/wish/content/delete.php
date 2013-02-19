<?php if(isset($_POST['gift']) AND $_POST['gift']) {
    $gift = $_POST['gift'];

    $queryString="SELECT id, title, link, description FROM wishes
                WHERE id = :wish_id
                ORDER BY id DESC LIMIT 0,1";
            $query = $bdd->prepare($queryString);
            $query->bindParam(':wish_id', $gift);
            $query->execute();
            $ligne = $query->fetch();
            extract($ligne);
?>
<form action="#" method="post">
    <h1 class="typein">Supprimer ce souhait ? </h1>
    <section class="typein">
        <input type="hidden" name="gift" value="<?php echo $gift?>"/>
        <h2><?php echo $title ?></h2>
    </section>

    <section class="submit_2">
        <input type="hidden" name="page" value="process_delete"/>
        <input class="validate" type="submit" value="" title="Valider"/>
        <span title="Annuler" class="cancel popin-close"><!-- --></span>
    </section>
</form>

<?php
}?>