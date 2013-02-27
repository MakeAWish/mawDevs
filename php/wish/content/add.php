<?php 
    $queryString="SELECT DISTINCT id, category FROM categories
                ORDER BY category";
            $query = $bdd->prepare($queryString);
            $query->execute();
?>

<form action="#" method="post">
    <h1 class="typein">Close your eyes...<br/> and make a wish* :</h1>
    <section class="typein">
        <p class="typein"><label for="title">Titre :</label>
            <input id="title" name="title" type="text" placeholder=" Titre" enctype="multipart/form-data"/></p>
        <p class="typein"><label for="link">Lien (facultatif) :</label>
            <input id="link" name="link" type="text" placeholder=" Lien" enctype="multipart/form-data"/></p>
        <p class="typein"><label for="description">Description :</label>
            <textarea id="description" name="description" placeholder=" Description" enctype="multipart/form-data"></textarea></p>
        <p class="typein"><label for="category">Catégorie :</label>
            <select name="category" id="category" enctype="multipart/form-data">
    
            <?php 
                $count = 0;
                while ($ligne = $query->fetch()) 
                {
                    extract($ligne);
                    $selected = "";
                    $count++; ?>                
                <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $category; ?></option>
                <?php } ?>
            </select>
    </section>


    <section class="submit_2">
        <input type="hidden" name="page" value="process_add"/>
        <input class="validate" type="submit" value="" title="Valider"/>
        <span title="Annuler" class="cancel popin-close"><!-- --></span>
    </section>
    <p class="asterisque">* Mais les yeux ouverts, c'est quand-même plus pratique !</p>
</form>


