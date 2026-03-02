<?php
include('../conn/conn.php');

if (isset($_GET['restaurant'])) {
    $restaurantID = $_GET['restaurant'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM tbl_restaurants WHERE id = ?");
    $stmt->execute([$restaurantID]);

    // Redirect back to the admin page after deletion
    header("location: http://localhost/food/admin1.php");
    exit();
} else {
    echo "No restaurant ID provided.";
}
?>
