<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<?php $getCardsByID = getCardsByID($pdo, $_GET['card_name_id']); ?>
	<h1>Are you sure you want to delete this card?</h1>
	<div class="container" style="border-style: solid; height: 400px;">
		<h2>Card Name: <?php echo $getCardsByID['card_name'] ?></h2>
		<h2>Booster Box Set: <?php echo $getCardsByID['boosterbox_set'] ?></h2>
		<h2>Rarity: <?php echo $getCardsByID['rarity'] ?></h2>
		<div class="deleteBtn" style="float: right; margin-right: 10px;">

			<form action="core/handleForms.php?card_name_id=<?php echo $_GET['card_name_id']; ?>&trading_card_game_id=<?php echo $_GET['trading_card_game_id']; ?>" method="POST">
				<input type="submit" name="deleteCardsBtn" value="Delete">
			</form>			
			
		</div>	

	</div>
</body>
</html>