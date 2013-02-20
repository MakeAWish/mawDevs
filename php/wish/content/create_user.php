<?php 

$queryString="SELECT DISTINCT id, name FROM colors
                ORDER BY name";
$query = $bdd->prepare($queryString);
$query->execute(); ?>

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
            <select name="color" id="color" enctype="multipart/form-data"/>
                <?php 
                $count = 0;
                while ($ligne = $query->fetch()) 
                {
                    extract($ligne);
                    $selected = "";
                    $additionalInfo = "";
                    if($count == 0)
                    {
                        $selected = "selected";
                        $additionalInfo = " (par défaut)";
                    } 
                    $count++; ?>                
                <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $name; echo $additionalInfo; ?></option>
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
        <input type="hidden" name="page" value="process_create_user"/>
        <input class="validate" type="submit" value="" title="Valider" onclick="formhash(this.form, this.form.password);"/>
    </section>
</form>
