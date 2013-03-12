<!-- On s'assure qu'il y a au moins un titre pour ajouter un cadeau dans la BDD, le lien et la description restent
optionnels -->


<!-- Code pour tous les messages d'erreur suite aux différentes modal -->

<?php
if(isset($_GET['add']) and ($_GET['add'] == 'failure')) {
	if(isset($_GET['cause']) and ($_GET['cause'] == 'title')) {
?>

	<script type="text/javascript">
		$(window).load(function(){
			modal.open({content:"Pas de titre, pas de cadeau !"});
		});
	</script>

<?php
	}
}
?>

<?php
if(isset($_GET['add']) and ($_GET['add'] == 'success')) {
?>

	<script type="text/javascript">
		$(window).load(function(){
			modal.open({content:"Voeu ajouté !"});
		});
	</script>

<?php
}
?>

<?php
if(isset($_GET['edit']) and ($_GET['edit'] == 'failure')) {
	if(isset($_GET['cause']) and ($_GET['cause'] == 'title')) {
?>

	<script type="text/javascript">
		$(window).load(function(){
			modal.open({content:"Il faut au moins garder un titre !"});
		});
	</script>

<?php
	}
}
?>

<?php
if(isset($_GET['edit']) and ($_GET['edit'] == 'success')) {
?>

	<script type="text/javascript">
		$(window).load(function(){
			modal.open({content:"Voeu modifié !"});
		});
	</script>

<?php
}
?>

<?php
if(isset($_GET['delete']) and ($_GET['delete'] == 'success')) {
?>

	<script type="text/javascript">
		$(window).load(function(){
			modal.open({content:"Voeu supprimé !"});
		});
	</script>

<?php
}
?>

<?php
if(isset($_GET['delete']) and ($_GET['delete'] == 'failure')) {
	if(isset($_GET['cause']) and ($_GET['cause'] == 'user')) {
?>

	<script type="text/javascript">
		$(window).load(function(){
			modal.open({content:"Vous n'avez pas le droit de supprimer ce voeu !"});
		});
	</script>

<?php
	}
}
?>

<!-- Code pour toutes les modal -->

<script type="text/javascript">
	$(window).load(function(){
		$(document).on("click", "input.add", function (e) {
        	e.preventDefault();
        	modal.open({url:"/?page=add"});
    	});

		$(document).on("click", "input.edit", function (e) {
        	e.preventDefault();
        	var checkedElement = $('.gift input:radio[name=gift]:checked').val();
        	modal.open({post:"/?page=edit", data : checkedElement});
    	});

		$(document).on("click", "input.delete", function (e) {
        	e.preventDefault();
        	var checkedElement = $('.gift input:radio[name=gift]:checked').val();
        	modal.open({post:"/?page=delete", data : checkedElement});
    	});

    	$(document).on("click", "input.validate.offer", function (e) {
        	e.preventDefault();
        	var selectedItems = new Array();
			$('.gift input:checkbox[name=gift]:checked').each(function() {
				selectedItems.push($(this).attr('value'));
			});
        	modal.open({post:"/?page=make_gift", data : selectedItems.join(",")});
    	});

    	$(document).on("click", "input.offered", function (e) {
        	e.preventDefault();
        	modal.open({post:"/?page=offered", data : $(e.currentTarget).siblings('input').val()});
    	});
	});
</script>


<!-- Code de la page -->

<section class="content">
<?php

	$my_id=$_SESSION['user_id'];
	$showEdit = true;
	$useridforfilter = $my_id;

	if(isset($_GET['user']) and ($_GET['user'] != $my_id)) {
		$useridforfilter = $_GET['user'] ;
		$showEdit = false;
	}

	try {

		$queryString="SELECT DISTINCT categories.id AS idcategory, category FROM wishes
					INNER JOIN categories ON wishes.idcategory = categories.id
					INNER JOIN wishlists ON wishes.idwishlist = wishlists.id
					INNER JOIN users ON wishlists.iduser = users.id
					INNER JOIN colors ON users.idcolor=colors.id
					LEFT JOIN gifts ON gifts.idwish = wishes.id
					WHERE users.id = :userid AND (gifts.offered = 0 OR gifts.offered IS NULL) AND wishes.deleted = 0
					ORDER BY category";
		$query = $bdd->prepare($queryString);
		$query->bindParam (':userid', $useridforfilter);
		$query->execute();

		while ($ligne = $query->fetch()) {
							extract($ligne); ?>
							<p class="category">
							<?php echo $category; ?>
							</p>


		<?php
		
			$queryString2="SELECT wishes.*, gifts.iduser, colors.name FROM wishes
					INNER JOIN categories ON wishes.idcategory = categories.id
					INNER JOIN wishlists ON wishes.idwishlist = wishlists.id
					INNER JOIN users ON wishlists.iduser = users.id
					INNER JOIN colors ON users.idcolor=colors.id
					LEFT JOIN gifts ON gifts.idwish = wishes.id
					WHERE users.id = :my_id AND (gifts.offered = 0 OR gifts.offered IS NULL) AND wishes.deleted = 0
					AND categories.id =:idcategory";
			$query2 = $bdd->prepare($queryString2);
			$query2->bindParam(':my_id', $useridforfilter);
			$query2->bindParam(':idcategory', $idcategory); // Bind "$email" to parameter.


		$query2->execute();
?>

			<form class="clic" method="post">
				
				<?php while ($ligne = $query2->fetch()) {
						extract($ligne);
						$classGift = "gift";
						$isBought = false;
						if($iduser != null)	{
							$classGift = "bought";
							$isBought = true;
						}

			if ($showEdit == false) { ?>

						<div class="<?php echo $classGift ?> non_exclusive">
							<?php if($isBought == false) { ?>
								<input type="checkbox" name="gift" value="<?php echo $id ?>"/>
								<?php } ?>

			<?php } else { ?>

						<div class="<?php echo $classGift ?> exclusive">
							<?php if($isBought == false) { ?>
								<input type="radio" name="gift" value="<?php echo $id ?>"/>
								<?php } ?>
			<?php }

					?>

						<span class="icon <?php echo $name ?>"><!-- --></span>
						<div class="gift_descr">
							<span class="gift_title"><?php echo $title ?></span>
							<p><?php echo $description ?></p>
						</div>
							<?php if($link!="") { ?>
									<a target="_blank" title="Suivez le lien !" href="<?php echo $link ?>"><div class="follow_link"></div></a>
							<?php } ?>
							<?php if($isBought== true && $showEdit == true) { ?>
									<input type="hidden" name="boughtId" value="<?php echo $id ?>" />
									<input type="submit" value="" class="offered" title="Cadeau reçu"/>
							<?php } ?>

						</div>
				<?php }	}?>
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
						<input class="validate offer" type="submit" value="" title="Offrir !"/>
					</section>
				<?php } ?>

			</form>

<?php }

		catch (PDOException $e)
		{
			echo 'Erreur : ' . $e->getMessage();
		}
?>