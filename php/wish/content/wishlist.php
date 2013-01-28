<?php

	$my_id=$_SESSION['user_id'];
	$showEdit = false;
		
	try {

		if(isset($_GET['user']) and ($_GET['user'] != $my_id)) {
			$showEdit = false;
			$queryString="SELECT wishes.*, gifts.iduser FROM wishes
				INNER JOIN wishlists ON wishes.idwishlist = wishlists.id
				INNER JOIN users ON wishlists.iduser = users.id
				LEFT JOIN gifts ON gifts.idwish = wishes.id
				WHERE users.id = :other_id";
			$query = $bdd->prepare($queryString);
			$query->bindParam(':other_id', $_GET['user']);
		}
	
		else {
			$showEdit = true;
			$queryString="SELECT wishes.*, gifts.iduser FROM wishes
					INNER JOIN wishlists ON wishes.idwishlist = wishlists.id
					INNER JOIN users ON wishlists.iduser = users.id
					LEFT JOIN gifts ON gifts.idwish = wishes.id
					WHERE users.id = :my_id";
			$query = $bdd->prepare($queryString);
			$query->bindParam(':my_id', $my_id); // Bind "$email" to parameter.
		}

		$query->execute();
?>

			<form class="clic" method="post">
				<section class="content">
				<?php while ($ligne = $query->fetch()) {
						extract($ligne);
						$classGift = "gift";
						$isBought = false;
						if($iduser != null)	{
							$classGift = "bought";
							$isBought = true;
						} ?>

						<div class="<?php echo $classGift ?> exclusive">

						<?php if($isBought == false) { ?>
								<input type="radio" name="gift" value="1"/>
						<?php } ?>

						<span class="icon"><!-- --></span>
						<div class="gift_descr">
							<span class="gift_title"><?php echo $title ?></span>
							<?php if($link!="") { ?>
									<a target="_blank" title="Suivez le lien !" href="<?php echo $link ?>"><div class="follow_link"></div></a>
							<?php } ?>
								<p><?php echo $description ?></p>
							</div>
						</div>
				<?php }	?>
				</section>

				<?php if ($showEdit) { ?>
					<section class="submit_3">
						<a href="/?page=add"><input class="add" type="submit" value="" title="Ajouter"/></a>
							<input class="edit" type="submit" value="" title="Modifier"/>
						<a href="delete.php"><input class="delete" type="submit" value="" title="Supprimer"/></a>
					</section>	
				<?php } 

				else { ?>
					<section class="submit_1">
						<input class="validate" type="submit" value="" title="Faire un cadeau"/>
					</section>
				<?php } ?>				
				
			</form>

<?php }
		catch (PDOException $e)
		{
			echo 'Erreur : ' . $e->getMessage();
		}
?>