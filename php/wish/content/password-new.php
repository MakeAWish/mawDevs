<?php
if (isset($_GET['linkid']) AND $_GET['linkid']) {
    $linkid = $_GET['linkid'];

    $reset = bdd_getResetUser($bdd, $linkid);

    if (is_null($reset)) {?>
        Une erreur empêche d'afficher la page ou le lien est obsolète.
    <?php
    } else { ?>
        <form method="post">
            <section class="typein">
                <p class="typein"><label for="password">Saisissez votre nouveau mot de passe :</label><input
                        id="password" type="password" placeholder=" Mot de passe" name="password"/></p>

                <p class="typein"><label for="password2">Confirmez votre nouveau mot de passe :</label><input
                        id="password2" type="password" placeholder=" Confirmation du mot de passe" name="password2"/>
                </p>
            </section>

            <section class="submit_1">
                <input type="hidden" name="page" value="login"/>
                <input type="hidden" name="action" value="reset_password"/>
                <input type="hidden" name="userid" value="<?php echo $reset->user_id ?>"/>
                <input class="validate" type="submit" value="" title="Valider"
                       onclick="formhash(this.form, this.form.password, this.form.password2);"/>
            </section>
        </form>
    <?php }
} else {
    ?>
    Il manque probablement un morceau de l'URL. Veuillez vérifier le mail qui vous a été envoyé.
<?php } ?>
