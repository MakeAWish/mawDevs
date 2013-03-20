<form method="post">
    <section class="typein">
        <p class="typein"><label for="username">Login :</label><input id="username" type="text" placeholder=" Login" name="username"/></p>
        <p class="typein"><label for="password">Mot de passe :</label><input id="password" type="password" placeholder=" Mot de passe"  name="password"/></p>
        <p class="forgot"><a href="/?page=reset" class="reset-password">mot de passe oublié ?</a></p>
    </section>

    <section class="submit_1">
        <input type="hidden" name="page" value="login"/>
        <input class="validate" type="submit" value="" title="Valider" onclick="formhash(this.form, this.form.password);" />
    </section>
</form>

