<script type="text/javascript" src="script/giftlist.js"></script>

<?php
// S'il y a une action à faire (ediction, suppression, ajout, on la fait)
if (isset($_POST['action'])) {
    include 'process/' . $_POST['action'] . '.php';
}

    $giftReceivers = array();
    $otherUsers = maw_otherUsers();
    $currentUser = maw_currentUser();

    foreach($otherUsers as &$otherUser){
        foreach($otherUser->wishlists as &$wishlist){
            foreach($wishlist->wishes as &$wish){
                if(($wish->reserved AND !$wish->offered)
                    AND $wish->buyer_id == $currentUser->id) {
                    array_push($giftReceivers, $otherUser);
                    break;
                }
            }
        }
    }
?>

<form class="clic" method="post">
    <section class="content" data-step="3" data-position="top" data-intro="Les cadeaux sont répartis par personne. Il n'y a plus qu'à les acheter et les offrir !">
        <?php

        foreach($giftReceivers as &$receiver){
            $getGiftsForReceiver = bdd_getGiftsForReceiver($bdd, $currentUser->id, $receiver->id);
            ?>
            <p class="gift_receiver">
                <?php echo $receiver->surname; ?>
            </p>
            <?php
            foreach($receiver->wishlists as &$wishlist){
                foreach($wishlist->wishes as &$wish){
                    if(($wish->reserved AND !$wish->offered)
                        AND $wish->buyer_id == $currentUser->id) {
                ?>
                <div class="gift non_exclusive">
                    <input type="checkbox" name="gift" value="<?php echo $wish->id ?>"/>

                    <div class="gift_img <?php echo $receiver->color->name ?>">&nbsp;</div><div class="gift_descr">
                        <span class="gift_title"><?php echo $wish->title ?></span>

                        <p><?php echo $wish->description ?></p>
                    </div>
                    <?php if ($wish->link != "") { ?>
                        <a target="_blank" title="Suivez le lien !" href="<?php echo $wish->link ?>">
                            <div class="follow_link"></div>
                        </a>
                    <?php } ?>
                </div>
            <?php
                }
            }
        }}
        ?>
    </section>

    <section class="submit_1" data-step="3" data-position="top" data-intro="Si vous changez d'avis sur un ou des cadeaux, sélectionnez-les et cliquez sur Supprimer">
        <input class="delete gifts" type="submit" value="" title="Supprimer de ma liste de cadeaux"/>
    </section>
</form>