<?php
// S'il y a une action à faire (ediction, suppression, ajout, on la fait)
if (isset($_POST['action'])) {
    include 'process/' . $_POST['action'] . '.php';
}

$current_user = new User($_SESSION['user_id']);
$colors = bdd_getColors($bdd);
?>

<form method="post">
    <section class="typein">
        <span class="typein" data-step="3" data-position="top"
        data-intro="Vous pouvez modifier diverses informations relatives à votre profil"> Modifier mon profil :</span>
        <input name="username" type="hidden" value="<?php echo $current_user->username ?>"/>

        <p class="typein"><label for="surname">Prénom :</label>
            <input name="surname" type="text" placeholder=" Prénom" value="<?php echo $current_user->surname ?>"/></p>

        <p class="typein"><label for="email">Email :</label>
            <input name="email" type="email" placeholder=" Email" value=" <?php echo $current_user->email ?>"/></p>

        <p class="typein"><label for="color">Couleur de thème :</label>
            <select name="color" id="color" enctype="multipart/form-data">
                <?php
                $count = 0;
                foreach($colors as &$color){
                    $selected = "";
                    if ($color->id == $current_user->color->id) {
                        $selected = "selected";
                    }
                    $count++; ?>
                    <option value="<?php echo $color->id; ?>" <?php echo $selected; ?>><?php echo $color->name ?></option>
                <?php } ?>
            </select>

        <hr/>

        <span class="typein" data-step="4" data-position="top"
        data-intro="Vous pouvez modifier votre mot de passe, à condition de connaître l'actuel bien sûr !">Modifier mon mot de passe :</span>

        <p class="typein"><label for="password">Mot de passe actuel :</label>
            <input name="password" type="password" placeholder=" Mot de passe"/></p>

        <p class="typein"><label for="new_password">Nouveau mot de passe :</label>
            <input name="new_password" type="password" placeholder=" Nouveau mot de passe"/></p>
    </section>

    <section class="submit_2"  data-step="5" data-position="top"
        data-intro="N'oubliez pas de valider, sinon ça ne sert à rien !">
        <input type="hidden" name="action" value="edit_profile"/>
        <input class="validate" type="submit" value="" title="Valider"
               onclick="formhash(this.form, this.form.password, this.form.new_password);"/>
        <input class="cancel" type="reset" value="" title="Annuler"/>
    </section>
</form>

