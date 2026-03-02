<?php
include('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurantID = $_POST['id'];
    $updateRestaurantName = $_POST['restaurant_name'];
    $updateAddress = $_POST['address'];
    $updateDescription = $_POST['description'];

    // Check if a new image file is uploaded
    if ($_FILES['image']['tmp_name'] != "") {
        $targetDir = "../images/";
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Update the restaurant information including the image
            $stmt = $conn->prepare("UPDATE tbl_restaurants SET restaurant_name = ?, address = ?, description = ?, image = ? WHERE id = ?");
            $stmt->execute([$updateRestaurantName, $updateAddress, $updateDescription, $_FILES['image']['name'], $restaurantID]);
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    } else {
        // Update the restaurant information without changing the image
        $stmt = $conn->prepare("UPDATE tbl_restaurants SET restaurant_name = ?, address = ?, description = ? WHERE id = ?");
        $stmt->execute([$updateRestaurantName, $updateAddress, $updateDescription, $restaurantID]);
    }

    // Redirect back to the main page after update
    header("location: http://localhost/food/admin1.php");
    exit();
}
?>
