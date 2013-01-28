<?php
if(isset($_GET['error'])) {
   echo 'Error Logging In : '.$_GET['error'].'!';
}
?>
<form method="post">
	<section class="typein">
		<p class="typein"><label for="email">Email :</label><input type="text" placeholder=" Login" name="email"/></p>
		<p class="typein"><label for="password">Mot de passe :</label><input type="password" placeholder=" Mot de passe"  name="password"/></p>
	</section>

	<section class="submit_1">
		<input type="hidden" name="page" value="process_login"/>
		<input class="validate" type="submit" value="" title="Valider" onclick="formhash(this.form, this.form.password);" />
	</section>
</form>

