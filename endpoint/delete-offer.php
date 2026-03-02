<?php
include('../conn/conn.php');

if (isset($_GET['offer'])) {
    $offerID = $_GET['offer'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM tbl_offers WHERE id = ?");
    $stmt->execute([$offerID]);

    // Redirect back to the admin page after deletion
    header("location: http://localhost/food/addoffer.php");
    exit();
} else {
    echo "No offer ID provided.";
}
?>
