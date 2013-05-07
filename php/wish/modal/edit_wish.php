<?php
// Connect to DB
include 'lib/init.php';
// Control User Rights and Status
include 'lib/control_login.php';

if (isset($_POST['data']) AND $_POST['data']) {

    $wish_id = $_POST['data'];
    $wish = new Wish($wish_id);
    $categories = maw_categories();

    ?>
    <form method="post">
        <h1 class="typein">Modifier ce souhait : </h1>
        <section class="typein">
            <input type="hidden" name="data" value="<?php echo $wish_id ?>"/>

            <p class="typein"><label for="title">Titre :</label>
                <input id="title" name="title" type="text" placeholder=" Titre" value="<?php echo $wish->title ?>"/></p>

            <p class="typein"><label for="link">Lien (facultatif) :</label>
                <input id="link" name="link" type="text" placeholder=" Lien" value="<?php echo $wish->link ?>"/></p>

            <p class="typein"><label for="description">Description :</label>
                <textarea id="description" name="description"
                          placeholder=" Description"><?php echo $wish->description ?></textarea></p>

            <p class="typein"><label for="category">Catégorie :</label>
                <select name="category" id="category" enctype="multipart/form-data">
                    <?php
                    foreach($categories as &$category) {
                        $selected = "";
                        if ($wish->category->id == $category->id) {
                            $selected = "selected";
                        }?>
                        <option
                            value="<?php echo $category->id ?>"<?php echo $selected; ?>><?php echo $category->name ?></option>
                    <?php } ?>
                </select>
            </p>
        </section>

        <section class="submit_2">
            <input type="hidden" name="action" value="edit_wish"/>
            <input class="validate" type="submit" value="" title="Valider"/>
            <span title="Annuler" class="cancel popin-close"><!-- --></span>
        </section>
    </form>

<?php
}?>