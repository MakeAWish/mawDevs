<?php
    if(isset($_GET['linkid']) AND $_GET['linkid']) {
        $linkid = $_GET['linkid'];

        $getReset = $bdd->prepare("SELECT user_id FROM login_reset WHERE linkid = :linkId AND used=0");
        $getReset->bindParam(":linkId", $linkid);
        $getReset->execute();
        if($getReset->rowCount() > 0){
            $reset = $getReset->fetch(PDO::FETCH_OBJ);
            $resetIsUsed = $bdd->prepare("UPDATE login_reset SET used=1 WHERE linkid = :linkId ");
            $resetIsUsed->bindParam(":linkId", $linkid);
            $resetIsUsed->execute();
            ?>
            <form method="post">
                <section class="typein">
                    <p class="typein"><label for="password">Saisissez votre nouveau mot de passe :</label><input id="password" type="password" placeholder=" Mot de passe" name="password"/></p>
                    <p class="typein"><label for="password2">Confirmez votre nouveau mot de passe :</label><input id="password2" type="password" placeholder=" Confirmation du mot de passe"  name="password2"/></p>
                </section>

                <section class="submit_1">
                    <input type="hidden" name="page" value="login"/>
                    <input type="hidden" name="action" value="reset_password" />
                    <input type="hidden" name="userid" value="<?php echo $reset->user_id ?>" />
                    <input class="validate" type="submit" value="" title="Valider" onclick="formhash(this.form, this.form.password, this.form.password2);" />
                </section>
            </form>
        <?php } else {?>
            blabla lien obsolète ou déjà utilisé
        <?php }
    } else {?>
Blablabla erreur paramètre
        <?php } ?>
