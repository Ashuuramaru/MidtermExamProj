<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cards</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="index.php">Return to home</a>
    <?php 
    if (isset($_GET['trading_card_game_id'])) {
        $trading_card_game_id = $_GET['trading_card_game_id'];
        $getAllInfoByCardGameID = getCardGameByID($pdo, $trading_card_game_id); // Use getCardGameByID to fetch the game info

        if ($getAllInfoByCardGameID) {
            echo "<h1>Card Game Name: " . htmlspecialchars($getAllInfoByCardGameID['cardgamename']) . "</h1>";
            echo "<h1>Add New Card</h1>";
            ?>

            <form action="core/handleForms.php?trading_card_game_id=<?php echo $trading_card_game_id; ?>" method="POST">
                <p>
                    <label for="card_name">Card Name</label>
                    <input type="text" name="cardName" required>
                </p>
                <p>
                    <label for="boosterBoxSet">Booster Box Set</label>
                    <input type="text" name="boosterBoxSet" required>
                </p>
                <p>
                    <label for="rarity">Rarity</label>
                    <input type="text" name="rarity" required>
                    <input type="submit" name="insertNewCardsBtn" value="Add Card">
                </p>
            </form>

            <table style="width:100%; margin-top: 50px;">
                <tr>
                    <th>Card ID</th>
                    <th>Card Name</th>
                    <th>Booster Box Set</th>
                    <th>Country Developed</th>
                    <th>Rarity</th>
                    <th>Added By</th>
                    <th>Last Updated</th>
                    <th>Action</th>
                </tr>
                <?php 
                $getCardsByCardGame = getCardsByCardGame($pdo, $trading_card_game_id);
                if ($getCardsByCardGame) {
                    foreach ($getCardsByCardGame as $row) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['card_name_id']) . "</td>
                                <td>" . htmlspecialchars($row['card_name']) . "</td>
                                <td>" . htmlspecialchars($row['boosterbox_set']) . "</td>
                                <td>" . htmlspecialchars($row['game_country_developed']) . "</td>
                                <td>" . htmlspecialchars($row['rarity']) . "</td>
                                <td>" . htmlspecialchars(getUsernameById($pdo, $row['added_by'])) . "</td>
                                <td>" . htmlspecialchars($row['last_updated']) . "</td>
                                <td>
                                    <a href='editcards.php?card_name_id=" . htmlspecialchars($row['card_name_id']) . "&trading_card_game_id=" . htmlspecialchars($trading_card_game_id) . "'>Edit</a>
                                    <a href='deletecards.php?card_name_id=" . htmlspecialchars($row['card_name_id']) . "&trading_card_game_id=" . htmlspecialchars($trading_card_game_id) . "'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No cards found for this Card Game ID.</td></tr>";
                }
                ?>
            </table>

            <?php
        } else {
            echo "<p>Invalid Card Game ID. Please try again.</p>";
        }
    }
    ?>
</body>
</html>
