<?php 

require_once 'dbConfig.php'; 
require_once 'models.php';

if (isset($_POST['insertCardGameBtn'])) {
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login
    $query = insertCardGame($pdo, $_POST['cardgamename'], $_POST['country'], $_POST['language'], $user_id);

    if ($query) {
        header("Location: ../index.php");
    } else {
        echo "Insertion failed";
    }
}

if (isset($_POST['insertNewCardsBtn'])) {
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
    $query = insertCards($pdo, $_POST['cardName'], $_POST['boosterBoxSet'], $_POST['rarity'], $_GET['trading_card_game_id'], $user_id);

    if ($query) {
        header("Location: ../viewcards.php?trading_card_game_id=" . $_GET['trading_card_game_id']);
    } else {
        echo "Insertion failed";
    }
}



if (isset($_POST['editCardGameBtn'])) {
	$query = updateCardGame($pdo, $_POST['cardgamename'], $_POST['country'],  $_POST['language'], $_GET['trading_card_game_id']);

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Edit failed";;
	}

}




if (isset($_POST['deleteCardGameBtn'])) {
	$query = deleteCardGame($pdo, $_GET['trading_card_game_id']);

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Deletion failed";
	}
}




if (isset($_POST['editCardsBtn'])) {
	$query = updateCards($pdo, $_POST['cardName'], $_POST['boosterBoxSet'], $_POST['rarity'],$_GET['trading_card_game_id']);

	if ($query) {
		header("Location: ../viewcards.php?trading_card_game_id=" .$_GET['trading_card_game_id']);
	}
	else {
		echo "Update failed";
	}

}




if (isset($_POST['deleteCardsBtn'])) {
	$query = deleteCards($pdo, $_GET['card_name_id']);

	if ($query) {
		header("Location: ../viewcards.php?trading_card_game_id=" .$_GET['trading_card_game_id']);
	}
	else {
		echo "Deletion failed";
	}
}


if (isset($_POST['registerUserBtn'])) {

	$username = $_POST['username'];
	$password = sha1($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$insertQuery = insertNewUser($pdo, $username, $password);

		if ($insertQuery) {
			header("Location: ../login.php");
		}
		else {
			header("Location: ../register.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure the input fields 
		are not empty for registration!";

		header("Location: ../login.php");
	}

}




if (isset($_POST['loginUserBtn'])) {

	$username = $_POST['username'];
	$password = sha1($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = loginUser($pdo, $username, $password);
	
		if ($loginQuery) {
			header("Location: ../index.php");
		}
		else {
			header("Location: ../login.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure the input fields 
		are not empty for the login!";
		header("Location: ../login.php");
	}
 
}



if (isset($_GET['logoutAUser'])) {
	unset($_SESSION['username']);
	header('Location: ../login.php');
}


?>