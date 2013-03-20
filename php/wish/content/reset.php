<?php
    // S'il y a une action à faire (ediction, suppression, ajout, on la fait)
    if(isset($_POST['action'])){
        include 'process/'.$_POST['action'].'.php';
    }
?>
<form method="post">
    <section class="typein">
        <p>Réinitalisation de votre mot de passe : </p>
        <p class="typein"><label for="username">Login :</label><input id="username" type="text" placeholder=" Login" name="username"/></p>
        <p class="forgot"><a href="/">se connecter</a></p>
    </section>

    <section class="submit_1">
        <input type="hidden" name="page" value="reset"/>
        <input type="hidden" name="action" value="reset_password"/>
        <input class="validate" type="submit" value="" title="Réinitialiser le mot de passe" />
    </section>
</form>

