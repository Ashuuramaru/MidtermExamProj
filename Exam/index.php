<?php 
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<?php if (isset($_SESSION['message'])) { ?>
		<h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
	<?php } unset($_SESSION['message']); ?>



	<?php if (isset($_SESSION['username'])) { ?>
		<h1>Hello there!! <?php echo $_SESSION['username']; ?></h1>
		<a href="core/handleForms.php?logoutAUser=1">Logout</a>
	<?php } else { echo "<h1>No user logged in</h1>";}?>

	<h3>Users List</h3>
	<ul>
		<?php $getAllUsers = getAllUsers($pdo); ?>
		<?php foreach ($getAllUsers as $row) { ?>
			<li>
				<a href="viewuser.php?user_id=<?php echo $row['user_id']; ?>"><?php echo $row['username']; ?></a>
			</li>
		<?php } ?>
	</ul>
	<h1>Welcome To Trading Card Shop. Add new cards!</h1>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="cardgamename">Card Game Name</label> 
			<input type="text" name="cardgamename">
		</p>
		<p>
			<label for="country">Country</label> 
			<input type="text" name="country">
		</p>
		<p>
			<label for="language">Language</label> 
			<input type="text" name="language">
			<input type="submit" name="insertCardGameBtn">
		</p>
	</form>
	<?php $getAllCardGame = getAllCardGame($pdo); ?>
	<?php foreach ($getAllCardGame as $row) { ?>
    <div class="container" style="border-style: solid; width: 50%; height: 300px; margin-top: 20px;">
        <h3>Card Game Name: <?php echo htmlspecialchars($row['cardgamename']); ?></h3>
        <h3>Country: <?php echo htmlspecialchars($row['country']); ?></h3>
        <h3>Language: <?php echo htmlspecialchars($row['language']); ?></h3>
        <p>Added By: <?php echo htmlspecialchars(getUsernameById($pdo, $row['added_by'])); ?></p>
        <p>Last Updated: <?php echo htmlspecialchars($row['last_updated']); ?></p>


		<div class="editAndDelete" style="float: right; margin-right: 20px;">
			<a href="viewcards.php?trading_card_game_id=<?php echo $row['trading_card_game_id']; ?>">View Cards</a>
			<a href="editcardgame.php?trading_card_game_id=<?php echo $row['trading_card_game_id']; ?>">Edit</a>
			<a href="deletecardgame.php?trading_card_game_id=<?php echo $row['trading_card_game_id']; ?>">Delete</a>
		</div>


	</div> 
	<?php } ?>
</body>
</html>