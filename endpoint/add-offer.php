<?php
include('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurantID = $_POST['restaurant_id'];
    $menuID = $_POST['menu_id'];
    $discountPercentage = $_POST['discount_percentage'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    $stmt = $conn->prepare("INSERT INTO tbl_offers (restaurant_id, menu_id, discount_percentage, start_time, end_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$restaurantID, $menuID, $discountPercentage, $startTime, $endTime]);

    // Redirect back to the admin page after addition
    header("location: http://localhost/food/addoffer.php");
    exit();
}
?>
