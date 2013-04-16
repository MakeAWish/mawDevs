<section class="content" data-step="3" data-position="top" data-intro="Voici les personnes à qui vous pouvez offrir un cadeau">
    <?php
    try {
        $user_id = $_SESSION['user_id'];
        $otherUsersThatHaveWishes = bdd_getOtherUsersThatHaveWishes($bdd, $user_id);
        foreach($otherUsersThatHaveWishes as &$user){
            ?>
            <a class="people" href="/?page=wishlist&user=<?php echo $user->id ?>">
                <div class="gift">
                    <div class="gift_img <?php echo $user->color ?>">&nbsp;</div>
                    <div class="gift_people"><?php echo $user->surname ?></div>
                </div>
            </a>
        <?php
        }
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
    ?>
</section>

