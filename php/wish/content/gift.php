<section class="content" data-step="3" data-position="top" data-intro="Voici les personnes à qui vous pouvez offrir un cadeau">
    <?php
    try {
        $otherUsers = maw_otherUsers();
        foreach($otherUsers as &$user){
            ?>
            <a class="people" href="/?page=wishlist&user=<?php echo $user->id ?>">
                <div class="gift">
                    <div class="gift_img <?php echo $user->color->name ?>">&nbsp;</div>
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

