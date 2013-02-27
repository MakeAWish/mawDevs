<?php
try {
	$user_id=$_SESSION['user_id'];
	$queryString="SELECT DISTINCT users.id, users.surname, colors.name AS color  FROM users
		INNER JOIN colors ON users.idcolor=colors.id
		INNER JOIN wishlists ON wishlists.iduser=users.id
		INNER JOIN wishes ON wishes.idwishlist=wishlists.id
		WHERE users.id <> :thisUser
		ORDER BY users.surname";
	$query = $bdd->prepare($queryString);
	$query->bindParam(':thisUser', $user_id); // Bind "$email" to parameter.
	$query->execute();
?>

	<section class="content">
	<?php while ($ligne = $query->fetch()) {
		extract($ligne);
	?>
		<a href="/?page=wishlist&user=<?php echo $id ?>">
			<div class="gift">
				<div class="gift_img <?php echo $color ?>">&nbsp;</div>
				<div class="gift_people"><?php echo $surname ?></div>
			</div>
		</a>
	<?php } ?>
	</section>

<?php }
catch (PDOException $e)
{
	echo 'Erreur : ' . $e->getMessage();
}
?>

