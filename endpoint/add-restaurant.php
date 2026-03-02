<?php
include('../conn/conn.php');

// Debug: Check if the script is receiving the form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Form submitted.<br>";

    $restaurantName = $_POST['restaurant_name'];
    $address = $_POST['address'];
    $description = $_POST['description'];

    // Debug: Print the received form data
    echo "Received data: Name - $restaurantName, Address - $address, Description - $description<br>";

    $restaurantImageName = $_FILES['image']['name'];
    $restaurantImageTmpName = $_FILES['image']['tmp_name'];

    // Debug: Print the file details
    echo "File details: Name - $restaurantImageName, Temp Name - $restaurantImageTmpName<br>";

    $target_dir = "../images/";
    $target_file = $target_dir . basename($restaurantImageName);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a valid image
    $check = getimagesize($restaurantImageTmpName);
    if ($check === false) {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "File already exists.<br>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "File is too large.<br>";
        $uploadOk = 0;
    }

    // Allow only certain image formats
    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "File format not allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>
            alert('Sorry, your file was not uploaded.');
            window.location.href = 'http://localhost/food/admin1.php';
        </script>";
    } else {
        if (move_uploaded_file($restaurantImageTmpName, $target_file)) {
            $restaurantImage = $restaurantImageName;

            $stmt = $conn->prepare("INSERT INTO `tbl_restaurants` (`id`, `image`, `restaurant_name`, `address`, `description`) VALUES (NULL, :restaurantImage, :restaurantName, :address, :description)");
            $stmt->bindParam(':restaurantImage', $restaurantImage);
            $stmt->bindParam(':restaurantName', $restaurantName);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':description', $description);
            $stmt->execute();

            header("location: http://localhost/food/admin1.php");
        } else {
            echo "<script>
                alert('Sorry, there was an error uploading your file.');
                window.location.href = 'http://localhost/food/admin1.php';
            </script>";
        }
    }
} else {
    echo "No form data received.<br>";
}
?>
