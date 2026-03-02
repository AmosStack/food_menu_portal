<?php
include('conn/conn.php');

function resolveImagePath($imageName) {
    $imageName = trim((string)$imageName);

    if ($imageName === '') {
        return 'img/bg.jpg';
    }

    if (strpos($imageName, 'images/') === 0 || strpos($imageName, 'img/') === 0) {
        return file_exists(__DIR__ . '/' . $imageName) ? $imageName : 'img/bg.jpg';
    }

    if (file_exists(__DIR__ . '/images/' . $imageName)) {
        return 'images/' . $imageName;
    }

    if (file_exists(__DIR__ . '/img/' . $imageName)) {
        return 'img/' . $imageName;
    }

    return 'img/bg.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management - Admin</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/page-transition.css">
    
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            background-image: url(img/bg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 93.6vh;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .manage-restaurant-container {
            display: flex;
            flex-direction: column;
            width: 1200px;
            height: 720px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.5);

        }

        .manage-restaurant-container > h2 {
            color: rgb(255, 255, 255);
            text-shadow: 2px 2px rgb(100, 100, 100);
        }

        table {
            color: rgb(255, 255, 255) !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar-header">
        <a class="navbar-brand ml-3" href="#">Restaurant Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home</a>
                </li>
            </ul>
            
            <a class="nav-link ml-auto" href="adminpage.php" style="color: rgb(255, 255, 255);">Admin Area</a>
        </div>
    </nav>      
    
    <div class="main">
        <div class="manage-restaurant-container">
            <h2>Manage Restaurant Area</h2>

            <div class="restaurant-container">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addRestaurantModal">Add Restaurant</button>

                <!-- Add Restaurant Modal -->
                <div class="modal fade" id="addRestaurantModal" tabindex="-1" aria-labelledby="addRestaurant" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addRestaurant">Add Restaurant</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="endpoint/add-restaurant.php" method="POST" class="add-form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="image">Restaurant Image:</label>
                                        <input type="file" class="form-control-file" id="image" name="image" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="restaurantName">Restaurant Name:</label>
                                        <input type="text" class="form-control" id="restaurantName" name="restaurant_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" class="form-control" id="address" name="address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description:</label>
                                        <textarea class="form-control" name="description" id="description" cols="30" rows="8"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-dark">Add</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Restaurant Modal -->
                <div class="modal fade" id="updateRestaurantModal" tabindex="-1" aria-labelledby="updateRestaurant" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateRestaurant">Update Restaurant</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="endpoint/update-restaurant.php" method="POST" class="add-form" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control-file" id="updateRestaurantID" name="id" required>
                                    <div class="form-group">
                                        <label for="updateImage">Restaurant Image:</label>
                                        <input type="file" class="form-control-file" id="updateImage" name="image">
                                    </div>
                                    <div class="form-group">
                                        <label for="updateRestaurantName">Restaurant Name:</label>
                                        <input type="text" class="form-control" id="updateRestaurantName" name="restaurant_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="updateAddress">Address:</label>
                                        <input type="text" class="form-control" id="updateAddress" name="address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="updateDescription">Description:</label>
                                        <textarea class="form-control" name="description" id="updateDescription" cols="30" rows="8"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-dark">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table mt-3">
                    <thead>
                        <tr>
                            <th>Restaurant ID</th>
                            <th>Image</th>
                            <th>Restaurant Name</th>
                            <th>Address</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $stmt = $conn->prepare("SELECT * FROM `tbl_restaurants`");
                            $stmt->execute();

                            $result = $stmt->fetchAll();

                            foreach($result as $row) {
                                $restaurantID = $row['id'];
                                $image = $row['image'];
                                $restaurantName = $row['restaurant_name'];
                                $address = $row['address'];
                                $description = $row['description'];
                                $restaurantImageSrc = resolveImagePath($image);
                                ?>

                                <tr>
                                    <th id="restaurantID-<?= $restaurantID ?>"><?= $restaurantID ?></th>
                                    <td id="image-<?= $restaurantID ?>"><img src="<?= htmlspecialchars($restaurantImageSrc) ?>" class="img-fluid" style="height: 80px; width:120px;" alt=""></td>
                                    <td id="restaurantName-<?= $restaurantID ?>"><?= $restaurantName ?></td>
                                    <td id="address-<?= $restaurantID ?>"><?= $address ?></td>
                                    <td id="description-<?= $restaurantID ?>"><?= $description ?></td>
                                    <td>
                                        <button type="submit" class="btn btn-secondary" onclick="updateRestaurant('<?= $restaurantID ?>')"><i class="fa-solid fa-pencil"></i></button>
                                        <button type="button" class="btn btn-danger" onclick="deleteRestaurant('<?= $restaurantID ?>')"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>

                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <!-- Make sure to include the full version of jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>
    function updateRestaurant(id) {
        $("#updateRestaurantModal").modal("show");

        let updateRestaurantID = $("#restaurantID-" + id).text();
        let updateRestaurantName = $("#restaurantName-" + id).text();
        let updateImage = $("#image-" + id).find('img').attr('src'); // Corrected this line
        let updateAddress = $("#address-" + id).text();
        let updateDescription = $("#description-" + id).text();

        $("#updateRestaurantID").val(updateRestaurantID);
        $("#updateRestaurantName").val(updateRestaurantName);
        $("#updateImage").find('img').attr('src', updateImage); // Updated this line
        $("#updateAddress").val(updateAddress);
        $("#updateDescription").val(updateDescription);
    }

    function deleteRestaurant(id){
        if(confirm("Do you confirm to delete this restaurant?")){
            window.location="endpoint/delete-restaurant.php?restaurant="+id;
        }
    }
</script>
<script src="assets/js/page-transition.js"></script>

</body>
</html>
