<?php
include('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menuID = $_POST['tbl_menu_id'];
    $updateMenuName = $_POST['menu_name'];
    $updatePrice = $_POST['price'];
    $updateDescription = $_POST['description'];

    // Check if a new image file is uploaded
    if ($_FILES['image']['tmp_name'] != "") {
        $targetDir = "../images/";
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

        // Update the contact information including the image
        $stmt = $conn->prepare("UPDATE tbl_menu SET menu_name = ?, price = ?, description = ?, image = ?  WHERE tbl_menu_id = ?");
        $stmt->execute([$updateMenuName, $updatePrice, $updateDescription, $_FILES['image']['name'], $menuID]);
    } else {
        // Update the contact information without changing the image
        $stmt = $conn->prepare("UPDATE tbl_menu SET menu_name = ?, price = ?, description = ? WHERE tbl_menu_id = ?");
        $stmt->execute([$updateMenuName, $updatePrice, $updateDescription, $menuID]);
    }

    // Redirect back to the main page after update
    header("location: http://localhost/food/admin.php");
    exit();
}
?>
