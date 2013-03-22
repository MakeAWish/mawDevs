<script type="text/javascript">

$(window).load(function(){
    $(document).on("click", "a.forgot", function (e) {
        e.preventDefault();
        modal.open({url:"/?page=reset_password&zajax=modal"});
    });
});
</script>


<form method="post">
    <section class="typein">
        <p class="typein"><label for="username">Login :</label><input id="username" type="text" placeholder=" Login" name="username"/></p>
        <p class="typein"><label for="password">Mot de passe :</label><input id="password" type="password" placeholder=" Mot de passe"  name="password"/>
        <a class="forgot" href="/?page=reset" class="reset-password">mot de passe oublié ?</a></p>
    </section>

    <section class="submit_1">
        <input type="hidden" name="page" value="login"/>
        <input class="validate" type="submit" value="" title="Valider" onclick="formhash(this.form, this.form.password);" />
    </section>
</form>

