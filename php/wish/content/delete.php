<form action="#" method="post">
    <h1 class="typein">Supprimer ce souhait : </h1>
    <section class="typein">
        <p class="typein"><label for="title">Titre :</label><input name="title" type="text" placeholder=" Titre"/></p>
        <p class="typein"><label for="link">Lien (facultatif) :</label><input name="link" type="text" placeholder=" Lien"/></p>
        <p class="typein"><label for="description">Description :</label><textarea name="description" placeholder=" Description"></textarea></p>
    </section>

    <section class="submit_2">
        <input type="hidden" name="page" value="process_add"/>
        <input class="validate" type="submit" value="" title="Valider"/>
        <span title="Annuler" class="cancel popin-close"><!-- --></span>
        <span class="close popin-close"><!-- --></span>
    </section>
</form>