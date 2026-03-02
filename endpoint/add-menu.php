<?php
include('../conn/conn.php');

$menuName = $_POST['menu_name'];
$price = $_POST['price'];
$description = $_POST['description'];

$menuImageName = $_FILES['image']['name'];
$menuImageTmpName = $_FILES['image']['tmp_name'];

$target_dir = "../images/";
$target_file = $target_dir . basename($menuImageName);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a valid image
$check = getimagesize($menuImageTmpName);
if($check === false) {
    $uploadOk = 0;
}

// Check if file already exists
if (file_exists($target_file)) {
    $uploadOk = 0;
}

// Check file size
if ($_FILES["image"]["size"] > 500000) {
    $uploadOk = 0;
}

// Allow only certain image formats
$allowedFormats = ["jpg", "jpeg", "png", "gif"];
if(!in_array($imageFileType, $allowedFormats)) {
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo " 
    <script>
        alert('Sorry, your file was not uploaded.');
        window.location.href = 'http://localhost/food/admin.php';
    </script>
    ";
} else {
    if (move_uploaded_file($menuImageTmpName, $target_file)) {
        $menuImage = $menuImageName;

        $stmt = $conn->prepare("INSERT INTO `tbl_menu` (`tbl_menu_id`,`image`, `menu_name`, `price`, `description`) VALUES (NULL, :menuImage, :menuName, :price, :description)");
        $stmt->bindParam(':menuImage', $menuImage);
        $stmt->bindParam(':menuName', $menuName);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        header("location: http://localhost/food/admin.php");
    } else {
        echo " 
        <script>
            alert('Sorry, there was an error uploading your file.');
            window.location.href = 'http://localhost/food/admin.php';
        </script>
        ";
    }
}
?>
