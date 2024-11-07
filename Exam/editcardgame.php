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
	<h1>Edit the user!</h1>
	<form action="core/handleForms.php?trading_card_game_id=<?php echo $_GET['trading_card_game_id']; ?>" method="POST">
		<p>
			<label for="cardgamename">Card Name</label> 
			<input type="text" name="cardgamename" value="<?php echo $getCardGameByID['cardgamename']; ?>">
		</p>
		<p>
			<label for="country">Country</label> 
			<input type="text" name="country" value="<?php echo $getCardGameByID['country']; ?>">
		</p>
		<p>
			<label for="language">Language</label> 
			<input type="text" name="language" value="<?php echo $getCardGameByID['language']; ?>">
			<input type="submit" name="editCardGameBtn">
		</p>
	</form>
</body>
</html>