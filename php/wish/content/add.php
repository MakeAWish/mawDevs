<form action="#" method="post">
    <section class="typein">
        <p class="typein"><label for="title">Titre :</label><input name="title" type="text" placeholder=" Titre"/></p>
        <p class="typein"><label for="link">Lien (facultatif) :</label><input name="link" type="text" placeholder=" Lien"/></p>
        <p class="typein"><label for="description">Description :</label><textarea name="description" placeholder=" Description"></textarea></p>
    </section>

    <section class="submit_2">
        <input type="hidden" name="page" value="process_add"/>
        <input class="validate" type="submit" value="" title="Valider"/>
        <a class="cancel" href="/page=wishlist"><!-- --><a/>
    </section>
</form>