<section class="content">
    <?php
    try {
        $user_id = $_SESSION['user_id'];
        $getUsersThatHaveWishes = $bdd->prepare("SELECT DISTINCT users.id, users.surname, colors.name AS color  FROM users
                                    INNER JOIN colors ON users.idcolor=colors.id
                                    INNER JOIN wishlists ON wishlists.iduser=users.id
                                    INNER JOIN wishes ON wishes.idwishlist=wishlists.id
                                    WHERE users.id <> :thisUser AND wishes.deleted = 0
                                    ORDER BY users.surname");
        $getUsersThatHaveWishes->bindParam(':thisUser', $user_id); // Bind "$email" to parameter.
        $getUsersThatHaveWishes->execute();

        while ($user = $getUsersThatHaveWishes->fetch(PDO::FETCH_OBJ)) {
            ?>
            <a href="/?page=wishlist&user=<?php echo $user->id ?>">
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

