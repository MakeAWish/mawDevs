<?php
    $my_id=$_SESSION['user_id'];
    $queryString="SELECT users.id, users.username, surname, email, password, idcolor AS useridcolor FROM users
                INNER JOIN colors ON colors.id=users.idcolor
                WHERE users.id = :user_id";
            $query = $bdd->prepare($queryString);
            $query->bindParam(':user_id', $my_id);
            $query->execute();
            $ligne = $query->fetch();
            extract($ligne);

    $queryString="SELECT DISTINCT id AS idcolor, name AS colorname FROM colors
                ORDER BY name";
            $query = $bdd->prepare($queryString);
            $query->execute();
?>

<form action="#" method="post">
    <section class="typein">
        <span class="typein"> Modifier mon profil :</span>
        <input name="username" type="hidden" value=" <?php echo $username ?>"/>
        <p class="typein"><label for="surname">Prénom :</label>
            <input name="surname" type="text" placeholder=" Prénom" value=" <?php echo $surname ?>"/></p>
        <p class="typein"><label for="email">Email :</label>
            <input name="email" type="email" placeholder=" Email" value=" <?php echo $email ?>"/></p>
        <p class="typein"><label for="color">Couleur de thème :</label>
            <select name="color" id="color" enctype="multipart/form-data">
            <?php
                $count = 0;
                while ($ligne = $query->fetch())
                {
                    extract($ligne);
                    $selected = "";
                    if($idcolor == $useridcolor)
                    {
                        $selected = "selected";
                    }
                    $count++; ?>
                <option value="<?php echo $idcolor; ?>" <?php echo $selected; ?>><?php echo $colorname; ?></option>
                <?php } ?>
            </select>

        <hr/>

        <span class="typein">Modifier mon mot de passe :</span>

        <p class="typein"><label for="password">Mot de passe actuel :</label>
            <input name="password" type="password" placeholder=" Mot de passe"/></p>
        <p class="typein"><label for="new_password">Nouveau mot de passe :</label>
            <input name="new_password" type="password" placeholder=" Nouveau mot de passe"/></p>
    </section>

    <section class="submit_2">
        <input type="hidden" name="page" value="process_profile"/>
        <input class="validate" type="submit" value="" title="Valider" onclick="formhash(this.form, this.form.password, this.form.new_password);" />
        <input class="cancel" type="reset" value ="" title="Annuler"/>
    </section>
</form>

