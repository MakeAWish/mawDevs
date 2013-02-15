<form action="#" method="post">
    <h1 class="typein">Close your eyes...<br/> and make a wish* :</h1>
    <section class="typein">
        <p class="typein"><label for="title">Titre :</label>
            <input name="title" type="text" placeholder=" Titre" enctype="multipart/form-data"/></p>
        <p class="typein"><label for="link">Lien (facultatif) :</label>
            <input name="link" type="text" placeholder=" Lien" enctype="multipart/form-data"/></p>
        <p class="typein"><label for="description">Description :</label>
            <textarea name="description" placeholder=" Description" enctype="multipart/form-data"></textarea></p>
    </section>

    <section class="submit_2">
        <input type="hidden" name="page" value="process_add"/>
        <input class="validate" type="submit" value="" title="Valider"/>
        <span title="Annuler" class="cancel popin-close"><!-- --></span>
    </section>
    <p class="asterisque">* Mais les yeux ouverts, c'est quand-même plus pratique !</p>
</form>


 