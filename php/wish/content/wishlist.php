<!-- On s'assure qu'il y a au moins un titre pour ajouter un cadeau dans la BDD, le lien et la description restent 
optionnels -->

<?php
if(isset($_GET['add']) and ($_GET['add'] == 'failure')) {
	if(isset($_GET['cause']) and ($_GET['cause'] == 'title')) {
?>

	<script type="text/javascript">
		$(window).load(function(){
			modal.open({content:"Il faut au moins le titre pour ajouter un cadeau"});
		});
	</script>

<?php
	}
}
?>

<script type="text/javascript">
	$(window).load(function(){
		$(document).on("click", "input.add", function (e) {
        	e.preventDefault();
        	modal.open({url:"/?page=add"});
    	});
	});
</script>

<script type="text/javascript">
	$(window).load(function(){
		$(document).on("click", "input.edit", function (e) {
        	e.preventDefault();
        	modal.open({url:"/?page=edit"});
    	});
	});
</script>

<script type="text/javascript">
	$(window).load(function(){
		$(document).on("click", "input.delete", function (e) {
        	e.preventDefault();
        	modal.open({url:"/?page=delete"});
    	});
	});
</script>

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
							<p><?php echo $description ?></p>
						</div>
							<?php if($link!="") { ?>
									<a target="_blank" title="Suivez le lien !" href="<?php echo $link ?>"><div class="follow_link"></div></a>
							<?php } ?>
							<?php if($isBought== true) { ?>
									<input type="submit" value="" class="offered" title="Cadeau reçu"/>
							<?php } ?>
								
						</div>
				<?php }	?>
				</section>

				<?php if ($showEdit) { ?>
					<section class="submit_3">
						<input class="add" type="submit" value="" title="Ajouter"/>
						<input class="edit" type="submit" value="" title="Modifier"/>
						<input class="delete" type="submit" value="" title="Supprimer"/>
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