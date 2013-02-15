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
    <h1 class="typein">Modifier ce souhait : </h1>
    <section class="typein">
        <input type="hidden" name="gift" value="<?php echo $gift?>"/>
        <p class="typein"><label for="title">Titre :</label>
            <input name="title" type="text" placeholder=" Titre" value="<?php echo $title ?>"/></p>
        <p class="typein"><label for="link">Lien (facultatif) :</label>
            <input name="link" type="text" placeholder=" Lien" value="<?php echo $link ?>"/></p>
        <p class="typein"><label for="description">Description :</label>
            <textarea name="description" placeholder=" Description"><?php echo $description ?></textarea></p>
    </section>

    <section class="submit_2">
        <input type="hidden" name="page" value="process_edit"/>
        <input class="validate" type="submit" value="" title="Valider"/>
        <span title="Annuler" class="cancel popin-close"><!-- --></span>
    </section>
</form>

<?php
}?>