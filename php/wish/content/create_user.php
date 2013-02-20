<form action="#" method="post">
    <h1 class="typein">Créer un nouvel utilisateur</h1>
    <section class="typein">
        <p class="typein"><label for="name">Nom :</label>
            <input name="name" type="text" placeholder=" Nom" enctype="multipart/form-data"/></p>
        <p class="typein"><label for="surname">Prénom :</label>
            <input name="surname" type="text" placeholder=" Prénom" enctype="multipart/form-data"/></p>
        <p class="typein"><label for="email">Email :</label>
            <input name="email" type="email" placeholder=" Email" enctype="multipart/form-data"/></p>
        <p class="typein"><label for="password">Mot de passe :</label>
            <input name="password" type="password" placeholder=" Mot de passe" enctype="multipart/form-data"/></p>
        <p class="typein"><label for="color">Couleur associée :</label>
            <select name="color" id="color" enctype="multipart/form-data"/>
                <option value="2" selected>Noir (par défaut)</option>
                <option value="3">Bleu</option>
                <option value="6">Bleu pâle</option>
                <option value="4">Brun</option>
                <option value="9">Rose</option>
                <option value="8">Rose pâle</option>
                <option value="11">Rouge</option>
                <option value="5">Vert</option>
                <option value="7">Vert pâle</option>
                <option value="10">Violet</option>
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
