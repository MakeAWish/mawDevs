<form action="#" method="post">
    <section class="typein">
        <p class="typein"><span>Login :</span><input type="text" placeholder=" Login" name="username"/></p>
        <p class="typein"><span>Mot de passe voulu :</span><input type="password" placeholder=" Mot de passe"  name="password"/></p>
    </section>
    <section class="submit_1">
        <input type="hidden" name="page" value="register"/>
        <input class="validate" type="submit" value="" title="Valider" onclick="formhash(this.form, this.form.password);" />
    </section>
</form>
<?php
    $passwordChanged = false;

    if(isset($_POST['p']))
    {
        $username = $_POST['username'];
        // The hashed password from the form
        $password = $_POST['p'];
        // Create a random salt
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        // Create salted password (Careful not to over season)
        $password = hash('sha512', $password.$random_salt);

        $passwordChanged = resetPassword($username, $password, $random_salt, $bdd);
    }

    if ($passwordChanged)
    { ?>
        <h1>Mot de passe mis à jour</h1>
<?php
    }
?>
