<script type="text/javascript" src="script/giftlist.js"></script>

<?php
// S'il y a une action à faire (ediction, suppression, ajout, on la fait)
if (isset($_POST['action'])) {
    include 'process/' . $_POST['action'] . '.php';
}
?>

<form class="clic" method="post">
    <section class="content">
        <?php
        $my_id = $_SESSION['user_id'];
        try {
            $getReveivers = $bdd->prepare("SELECT DISTINCT users.surname, colors.name AS color FROM gifts
                                                        INNER JOIN wishes ON gifts.idwish = wishes.id
                                                        INNER JOIN wishlists ON wishlists.id = wishes.idwishlist
                                                        INNER JOIN users ON users.id = wishlists.iduser
                                                        INNER JOIN colors ON colors.id = users.idcolor
                                                        WHERE gifts.iduser = :gift_userid AND (gifts.offered = 0 OR gifts.offered IS NULL)
                                                        ORDER BY users.surname");
            $getReveivers->bindParam(':gift_userid', $my_id);
            $getReveivers->execute();

            while ($receiver = $getReveivers->fetch(PDO::FETCH_OBJ)) {
                ?>
                <p class="gift_receiver">
                    <?php echo $receiver->surname; ?>
                </p>

                <?php
                $getGiftsForReceiver = $bdd->prepare("SELECT title, link, description, gifts.id AS id, offered FROM gifts
                        INNER JOIN wishes ON gifts.idwish = wishes.id
                        INNER JOIN wishlists ON wishlists.id = wishes.idwishlist
                        INNER JOIN users ON users.id = wishlists.iduser
                        WHERE gifts.iduser = :gift_userid AND surname = :gift_receiver AND (gifts.offered = 0 OR gifts.offered IS NULL)");
                $getGiftsForReceiver->bindParam(':gift_userid', $my_id);
                $getGiftsForReceiver->bindParam(':gift_receiver', $receiver->surname);
                $getGiftsForReceiver->execute();

                while ($gift = $getGiftsForReceiver->fetch(PDO::FETCH_OBJ)) {
                    ?>
                    <div class="gift non_exclusive">
                        <input type="checkbox" name="gift" value="<?php echo $gift->id ?>"/>

                        <div class="gift_img <?php echo $receiver->color ?>">&nbsp;</div>
                        <div class="gift_descr">
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

    <section class="submit_1">
        <input class="delete gifts" type="submit" value="" title="Supprimer de ma liste de cadeaux"/>
    </section>
</form>