<?php require_once 'core/handleForms.php'; ?>
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
	<?php $getCardGameByID = getCardGameByID($pdo, $_GET['trading_card_game_id']); ?>
	<h1>Are you sure you want to delete this card game?</h1>
	<div class="container" style="border-style: solid; height: 400px;">
		<h2>Card Game Name: <?php echo $getCardGameByID['cardgamename'] ?></h2>
		<h2>Country: <?php echo $getCardGameByID['country'] ?></h2>
		<h2>Language: <?php echo $getCardGameByID['language'] ?></h2>
		<div class="deleteBtn" style="float: right; margin-right: 10px;">

			<form action="core/handleForms.php?trading_card_game_id=<?php echo $_GET['trading_card_game_id']; ?>&trading_card_game_id=<?php echo $_GET['trading_card_game_id']; ?>" method="POST">
				<input type="submit" name="deleteCardGameBtn" value="Delete">
			</form>			
			
		</div>	

	</div>
</body>
</html>