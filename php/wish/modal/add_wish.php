<?php
    // Connect to DB
    include 'init.php';
    // Control User Rights and Status
    include 'control_login.php';
?>

<form method="post">
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
                $getCategories = $bdd->prepare("SELECT DISTINCT id, category AS name FROM categories
                                                ORDER BY category");
                $getCategories->execute();
                while ($category = $getCategories->fetch(PDO::FETCH_OBJ))
                {?>
                    <option value="<?php echo $category->id ?>"><?php echo $category->name; ?></option>
                <?php } ?>
            </select>
        </p>
    </section>


    <section class="submit_2">
        <input type="hidden" name="action" value="add_wish"/>
        <input class="validate" type="submit" value="" title="Valider"/>
        <span title="Annuler" class="cancel popin-close"><!-- --></span>
    </section>
    <p class="asterisque">* Mais les yeux ouverts, c'est quand-même plus pratique !</p>
</form>


