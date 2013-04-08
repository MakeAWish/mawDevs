<?php
// S'il y a une action à faire (ediction, suppression, ajout, on la fait)
if (isset($_POST['action'])) {
    include 'process/' . $_POST['action'] . '.php';
}
?>

<form action="#" method="post">
    <h1 class="typein">Créer un nouvel utilisateur</h1>
    <section class="typein">
        <p class="typein"><label for="username">Login :</label>
            <input name="username" type="text" placeholder=" login" enctype="multipart/form-data"/></p>

        <p class="typein"><label for="surname">Prénom :</label>
            <input name="surname" type="text" placeholder=" Prénom" enctype="multipart/form-data"/></p>

        <p class="typein"><label for="email">Email :</label>
            <input name="email" type="email" placeholder=" Email" enctype="multipart/form-data"/></p>

        <p class="typein"><label for="password">Mot de passe :</label>
            <input name="password" type="password" placeholder=" Mot de passe" enctype="multipart/form-data"/></p>

        <p class="typein"><label for="color">Couleur associée :</label>
            <select name="color" id="color" enctype="multipart/form-data">
                <?php
                $getColors = $bdd->prepare("SELECT DISTINCT id, name FROM colors
                                            ORDER BY name");
                $getColors->execute();
                $count = true;
                while ($color = $getColors->fetch(PDO::FETCH_OBJ)) {
                    $selected = "";
                    $additionalInfo = "";
                    if ($count) {
                        $selected = "selected";
                        $additionalInfo = " (par défaut)";
                        $count = false;
                    }?>
                    <option
                        value="<?php echo $color->id; ?>" <?php echo $selected; ?>><?php echo $color->name; echo $additionalInfo; ?></option>
                <?php } ?>
            </select>
        </p>
        <p class="typein"><label for="admin">Droits d'admin :</label>
            <select name="admin" id="admin_rights" enctype="multipart/form-data"/>
            <option value="0" selected>Non (par défaut)</option>
            <option value="1">Oui</option>
            </select>
        </p>
    </section>

    <section class="submit_1">
        <input type="hidden" name="action" value="create_user"/>
        <input class="validate" type="submit" value="" title="Valider"
               onclick="formhash(this.form, this.form.password);"/>
    </section>
</form>
