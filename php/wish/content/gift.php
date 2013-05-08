<section class="content" data-step="3" data-position="top" data-intro="Voici les personnes à qui vous pouvez offrir un cadeau">
    <?php
    $giftReceivers = array();
    $otherUsers = maw_otherUsers();

    foreach($otherUsers as &$otherUser){
        foreach($otherUser->wishlists as &$wishlist){
            foreach($wishlist->wishes as &$wish){
                if(!$wish->reserved && !$wish->offered) {
                    array_push($giftReceivers, $otherUser);
                    break;
                }
            }
        }
    }

    foreach($giftReceivers as &$user){
        ?>
        <a class="people" href="/?page=wishlist&user=<?php echo $user->id ?>">
            <div class="gift">
                <div class="gift_img <?php echo $user->color->name ?>">&nbsp;</div>
                <div class="gift_people"><?php echo $user->surname ?></div>
            </div>
        </a>
    <?php
    }
    ?>
</section>

