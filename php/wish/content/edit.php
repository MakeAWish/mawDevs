<?php if(isset($_POST['gift']) AND $_POST['gift']) {
    $gift = $_POST['gift'];

    $queryString="SELECT wishes.id, title, link, description, idcategory AS wishcategoryid FROM wishes
                WHERE wishes.id = :wish_id
                ORDER BY wishes.id DESC LIMIT 0,1";
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
            <input id="title" name="title" type="text" placeholder=" Titre" value="<?php echo $title ?>"/></p>
        <p class="typein"><label for="link">Lien (facultatif) :</label>
            <input id="link" name="link" type="text" placeholder=" Lien" value="<?php echo $link ?>"/></p>
        <p class="typein"><label for="description">Description :</label>
            <textarea id="description" name="description" placeholder=" Description"><?php echo $description ?></textarea></p>
        <p class="typein"><label for="category">Catégorie :</label>
            <select name="category" id="category" enctype="multipart/form-data">

            <?php 

            $queryString2="SELECT DISTINCT id AS category_id, category FROM categories
                ORDER BY category_id";
            $query2 = $bdd->prepare($queryString2);
            $query2->execute();
                while ($ligne = $query2->fetch()) 
                {
                    extract($ligne);
                    $selected = "";
                    if ($wishcategoryid == $category_id) {
                        $selected = "selected";
                    }?> 
                <option value="<?php echo $category_id; ?>"<?php echo $selected; ?>><?php echo $category; ?></option>
                <?php } ?>
            </select>
        </p>
    </section>

    <section class="submit_2">
        <input type="hidden" name="page" value="process_edit"/>
        <input class="validate" type="submit" value="" title="Valider"/>
        <span title="Annuler" class="cancel popin-close"><!-- --></span>
    </section>
</form>

<?php
}?>