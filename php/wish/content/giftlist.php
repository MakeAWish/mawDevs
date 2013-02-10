<?php 

	$my_id=$_SESSION['user_id'];
		
	try {
		
		$queryString="SELECT DISTINCT surname, colors.name AS color FROM gifts
		INNER JOIN wishes ON gifts.idwish = wishes.id
		INNER JOIN wishlists ON wishlists.id = wishes.idwishlist
		INNER JOIN users ON users.id = wishlists.iduser
		INNER JOIN colors ON colors.id = users.idcolor
		WHERE gifts.iduser = :gift_userid";
		$query = $bdd->prepare($queryString);
		$query->bindParam(':gift_userid', $my_id);
		$query->execute(); ?>

			<form class="clic" method="post">
				<section class="content">
					
						<?php while ($ligne = $query->fetch()) {
							extract($ligne); ?>
							<p class="gift_receiver">
							<?php echo $surname; ?>
							</p>

						<?php $queryString2="SELECT title, link, description, gifts.id AS id_gift FROM gifts
							INNER JOIN wishes ON gifts.idwish = wishes.id
							INNER JOIN wishlists ON wishlists.id = wishes.idwishlist
							INNER JOIN users ON users.id = wishlists.iduser
							WHERE gifts.iduser = :gift_userid AND surname = :gift_receiver";
							$query2 = $bdd->prepare($queryString2);
							$query2->bindParam(':gift_userid', $my_id);
							$query2->bindParam(':gift_receiver', $surname);
							$query2->execute(); 
							
							while ($ligne = $query2->fetch()) {
								extract($ligne); ?>
								<div class="gift non_exclusive">
								<input type="checkbox" name="gift" value="<?php echo $id_gift ?>"/>
									<div class="gift_img <?php echo $color ?>">&nbsp;</div>
									<div class="gift_descr">
										<span class="gift_title"><?php echo $title ?></span>	
										<p><?php echo $description ?></p>
									</div>
									<?php if($link!="") { ?>
										<a target="_blank" title="Suivez le lien !" href="<?php echo $link ?>"><div class="follow_link"></div></a>
									<?php } ?>
								</div>
							<?php }
							
						} ?>
				</section>

				<section class="submit_1">
					<a href="delete.php"><input class="delete" type="submit" value="" title="Supprimer de ma liste de cadeaux"/></a>
				</section>			
			</form>

<?php }
		catch (PDOException $e)
		{
			echo 'Erreur : ' . $e->getMessage();
		}
?>