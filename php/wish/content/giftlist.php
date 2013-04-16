<script type="text/javascript" src="script/giftlist.js"></script>

<?php
// S'il y a une action à faire (ediction, suppression, ajout, on la fait)
if (isset($_POST['action'])) {
    include 'process/' . $_POST['action'] . '.php';
}
?>

<form class="clic" method="post">
    <section class="content" data-step="3" data-position="top" data-intro="Les cadeaux sont répartis par personne. Il n'y a plus qu'à les acheter et les offrir !">
        <?php
        $my_id = $_SESSION['user_id'];
        try {
            $getGiftsReceivers = bdd_getGiftsReceivers($bdd, $my_id);
            foreach($getGiftsReceivers as &$receiver){
                $getGiftsForReceiver = bdd_getGiftsForReceiver($bdd, $my_id, $receiver->surname);
                ?>
                <p class="gift_receiver">
                    <?php echo $receiver->surname; ?>
                </p>
                <?php foreach($getGiftsForReceiver as &$gift){
                    ?>
                    <div class="gift non_exclusive">
                        <input type="checkbox" name="gift" value="<?php echo $gift->id ?>"/>

                        <div class="gift_img <?php echo $receiver->color ?>">&nbsp;</div><div class="gift_descr">
                            <span class="gift_title"><?php echo $gift->title ?></span>

                            <p><?php echo $gift->description ?></p>
                        </div>
                        <?php if ($gift->link != "") { ?>
                            <a target="_blank" title="Suivez le lien !" href="<?php echo $gift->link ?>">
                                <div class="follow_link"></div>
                            </a>
                        <?php } ?>
                    </div>
                <?php
                }
            }
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
        }?>
    </section>

    <section class="submit_1" data-step="3" data-position="top" data-intro="Si vous changez d'avis sur un ou des cadeaux, sélectionnez-les et cliquez sur Supprimer">
        <input class="delete gifts" type="submit" value="" title="Supprimer de ma liste de cadeaux"/>
    </section>
</form>