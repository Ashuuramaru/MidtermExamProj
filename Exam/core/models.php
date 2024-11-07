<?php  

function insertCardGame($pdo, $cardgamename, $country, $language, $added_by) {
    $sql = "INSERT INTO trading_card_game (cardgamename, country, language, added_by) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$cardgamename, $country, $language, $added_by]);

	if ($executeQuery) {
		return true;
	}
}



function updateCardGame($pdo, $cardgamename, $country, $language,  $trading_card_game_id) {

	$sql = "UPDATE trading_card_game
				SET cardgamename = ?,
					country = ?, 
					language = ?
				WHERE trading_card_game_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$cardgamename, $country, $language, $trading_card_game_id]);
	
	if ($executeQuery) {
		return true;
	}

}


function deleteCardGame($pdo, $trading_card_game_id) {
	$deleteCardGameCard = "DELETE FROM cards WHERE trading_card_game_id = ?";
	$deleteStmt = $pdo->prepare($deleteCardGameCard);
	$executeDeleteQuery = $deleteStmt->execute([$trading_card_game_id]);

	if ($executeDeleteQuery) {
		$sql = "DELETE FROM trading_card_game WHERE trading_card_game_id = ?";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$trading_card_game_id]);

		if ($executeQuery) {
			return true;
		}

	}
	
}




function getAllCardGame($pdo) {
	$sql = "SELECT * FROM trading_card_game";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getCardGameByID($pdo, $trading_card_game_id) {
	$sql = "SELECT * FROM trading_card_game WHERE trading_card_game_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$trading_card_game_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}





function getCardsByCardGame($pdo, $trading_card_game_id) {
    $sql = "SELECT 
                cards.card_name_id AS card_name_id,
                cards.card_name AS card_name,
                cards.boosterbox_set AS boosterbox_set,
                cards.rarity AS rarity,	                
				cards.added_by AS added_by,
                cards.last_updated AS last_updated,
                CONCAT(trading_card_game.cardgamename, ' ', trading_card_game.country) AS game_country_developed
            FROM cards
            JOIN trading_card_game ON cards.trading_card_game_id = trading_card_game.trading_card_game_id
            WHERE cards.trading_card_game_id = ? 
            GROUP BY cards.card_name;
            ";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$trading_card_game_id]);
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}



function insertCards($pdo, $card_name, $boosterbox_set, $rarity, $trading_card_game_id, $added_by) {
    $sql = "INSERT INTO cards (card_name, boosterbox_set, rarity, trading_card_game_id, added_by) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$card_name, $boosterbox_set, $rarity, $trading_card_game_id, $added_by]);
}


function updateCards($pdo, $cardName, $boosterBoxSet, $rarity, $cardNameID) {
    $sql = "UPDATE cards SET card_name = ?, boosterbox_set = ?, rarity = ? WHERE card_name_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$cardName, $boosterBoxSet, $rarity, $cardNameID]);
}

function getCardsByID($pdo, $card_name_id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM cards WHERE card_name_id = :card_name_id");
        $stmt->execute(['card_name_id' => $card_name_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        return null; // or handle the error as needed
    }
}

function deleteCards($pdo, $card_name_id) {
	$sql = "DELETE FROM cards WHERE card_name_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$card_name_id]);
	if ($executeQuery) {
		return true;
	}
}

function getAllInfoByCardGameID($pdo, $trading_card_game_id) {
    $sql = "SELECT * FROM trading_card_game WHERE trading_card_game_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$trading_card_game_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
    return null;
}

function insertNewUser($pdo, $username, $password) {

	$checkUserSql = "SELECT * FROM user_passwords WHERE username = ?";
	$checkUserSqlStmt = $pdo->prepare($checkUserSql);
	$checkUserSqlStmt->execute([$username]);

	if ($checkUserSqlStmt->rowCount() == 0) {

		$sql = "INSERT INTO user_passwords (username,password) VALUES(?,?)";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$username, $password]);

		if ($executeQuery) {
			$_SESSION['message'] = "User successfully inserted";
			return true;
		}

		else {
			$_SESSION['message'] = "An error occured from the query";
		}

	}
	else {
		$_SESSION['message'] = "User already exists";
	}

	
}



function loginUser($pdo, $username, $password) {
	$sql = "SELECT * FROM user_passwords WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]); 

	if ($stmt->rowCount() == 1) {
		$userInfoRow = $stmt->fetch();
		$usernameFromDB = $userInfoRow['username']; 
		$passwordFromDB = $userInfoRow['password'];

		if ($password == $passwordFromDB) {
			$_SESSION['username'] = $usernameFromDB;
			$_SESSION['message'] = "Login successful!";
			return true;
		}

		else {
			$_SESSION['message'] = "Password is invalid, but user exists";
		}
	}

	
	if ($stmt->rowCount() == 0) {
		$_SESSION['message'] = "Username doesn't exist from the database. You may consider registration first";
	}

}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_passwords";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}

}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * FROM user_passwords WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function getUsernameById($pdo, $user_id) {
    $sql = "SELECT username FROM user_passwords WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchColumn();
}



?>