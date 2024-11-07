<?php 
require_once 'core/handleForms.php'; 
require_once 'core/models.php'; 

if (isset($_GET['card_name_id']) && isset($_GET['trading_card_game_id'])) {
    $cardNameID = $_GET['card_name_id'];
    $tradingCardGameID = $_GET['trading_card_game_id'];

    $getCardsByID = getCardsByID($pdo, $cardNameID); 
    if (!$getCardsByID) {
        echo "Invalid Card ID"; 
        exit;
    }
} else {
    echo "Missing parameters"; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Card</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit Card</h1>
    <form action="core/handleForms.php?trading_card_game_id=<?php echo $tradingCardGameID; ?>" method="POST">
        <input type="hidden" name="card_name_id" value="<?php echo $cardNameID; ?>"> 
        <p>
            <label for="card_name">Card Name</label>
            <input type="text" name="cardName" value="<?php echo htmlspecialchars($getCardsByID['card_name']); ?>" required>
        </p>
        <p>
            <label for="boosterBoxSet">Booster Box Set</label>
            <input type="text" name="boosterBoxSet" value="<?php echo htmlspecialchars($getCardsByID['boosterbox_set']); ?>" required>
        </p>
        <p>
            <label for="rarity">Rarity</label>
            <input type="text" name="rarity" value="<?php echo htmlspecialchars($getCardsByID['rarity']); ?>" required>
        </p>
        <input type="submit" name="editCardsBtn" value="Update Card">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editCardsBtn'])) {
        $updateResult = updateCards($pdo, $_POST['cardName'], $_POST['boosterBoxSet'], $_POST['rarity'], $_POST['card_name_id']);
        if ($updateResult) {
            header("Location: viewcards.php?trading_card_game_id=$tradingCardGameID");
            exit();
        } else {
            echo "Update failed. Please try again.";
        }
    }
    ?>
</body>
</html>
