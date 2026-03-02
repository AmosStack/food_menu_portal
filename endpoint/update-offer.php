<?php
include('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $offerID = $_POST['id'];
    $restaurantID = $_POST['restaurant_id'];
    $menuID = $_POST['menu_id'];
    $discountPercentage = $_POST['discount_percentage'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    $stmt = $conn->prepare("UPDATE tbl_offers SET restaurant_id = ?, menu_id = ?, discount_percentage = ?, start_time = ?, end_time = ? WHERE id = ?");
    $stmt->execute([$restaurantID, $menuID, $discountPercentage, $startTime, $endTime, $offerID]);

    // Redirect back to the main page after updating offer
    header("location: http://localhost/food/addoffer.php");
    exit();
}
?>
