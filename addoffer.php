<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Management - Admin</title>

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

        .manage-offer-container {
            display: flex;
            flex-direction: column;
            width: 1200px;
            height: 720px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.5);

        }

        .manage-offer-container > h2 {
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
    <a class="navbar-brand ml-3" href="#">Offer Management</a>
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
    <div class="manage-offer-container">
        <h2>Manage Offer Area</h2>

        <div class="offer-container">
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addOfferModal">Add Offer</button>

            <!-- Add Offer Modal -->
            <div class="modal fade" id="addOfferModal" tabindex="-1" aria-labelledby="addOffer" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addOffer">Add Offer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="endpoint/add-offer.php" method="POST" class="add-form">
                                <div class="form-group">
                                    <label for="restaurantID">Restaurant:</label>
                                    <select class="form-control" id="restaurantID" name="restaurant_id" required>
                                        <?php 
                                            include('conn/conn.php');
                                            $stmt = $conn->prepare("SELECT * FROM tbl_restaurants");
                                            $stmt->execute();
                                            $restaurants = $stmt->fetchAll();

                                            foreach($restaurants as $restaurant) {
                                                echo "<option value='".$restaurant['id']."'>".$restaurant['restaurant_name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="menuID">Menu:</label>
                                    <select class="form-control" id="menuID" name="menu_id" required>
                                        <?php 
                                            $stmt = $conn->prepare("SELECT * FROM tbl_menu");
                                            $stmt->execute();
                                            $menus = $stmt->fetchAll();

                                            foreach($menus as $menu) {
                                                echo "<option value='".$menu['tbl_menu_id']."'>".$menu['menu_name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="discountPercentage">Discount Percentage:</label>
                                    <input type="number" class="form-control" id="discountPercentage" name="discount_percentage" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label for="startTime">Start Time:</label>
                                    <input type="datetime-local" class="form-control" id="startTime" name="start_time" required>
                                </div>
                                <div class="form-group">
                                    <label for="endTime">End Time:</label>
                                    <input type="datetime-local" class="form-control" id="endTime" name="end_time" required>
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





            <!-- Update Offer Modal -->
            <div class="modal fade" id="updateOfferModal" tabindex="-1" aria-labelledby="updateOffer" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateOffer">Update Offer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="endpoint/update-offer.php" method="POST" class="update-form">
                                <input type="hidden" class="form-control-file" id="updateOfferID" name="id" required>
                                <div class="form-group">
                                    <label for="updateRestaurantID">Restaurant:</label>
                                    <select class="form-control" id="updateRestaurantID" name="restaurant_id" required>
                                        <?php 
                                            foreach($restaurants as $restaurant) {
                                                echo "<option value='".$restaurant['id']."'>".$restaurant['restaurant_name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="updateMenuID">Menu:</label>
                                    <select class="form-control" id="updateMenuID" name="menu_id" required>
                                        <?php 
                                            foreach($menus as $menu) {
                                                echo "<option value='".$menu['tbl_menu_id']."'>".$menu['menu_name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="updateDiscountPercentage">Discount Percentage:</label>
                                    <input type="number" class="form-control" id="updateDiscountPercentage" name="discount_percentage" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label for="updateStartTime">Start Time:</label>
                                    <input type="datetime-local" class="form-control" id="updateStartTime" name="start_time" required>
                                </div>
                                <div class="form-group">
                                    <label for="updateEndTime">End Time:</label>
                                    <input type="datetime-local" class="form-control" id="updateEndTime" name="end_time" required>
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
                        <th>Offer ID</th>
                        <th>Restaurant</th>
                        <th>Menu</th>
                        <th>Discount Percentage</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        include('conn/conn.php');

                        $stmt = $conn->prepare("SELECT tbl_offers.*, tbl_restaurants.restaurant_name, tbl_menu.menu_name 
                                                FROM tbl_offers
                                                JOIN tbl_restaurants ON tbl_offers.restaurant_id = tbl_restaurants.id
                                                JOIN tbl_menu ON tbl_offers.menu_id = tbl_menu.tbl_menu_id");
                        $stmt->execute();

                        $offers = $stmt->fetchAll();

                        foreach($offers as $offer) {
                            $offerID = $offer['id'];
                            $restaurantName = $offer['restaurant_name'];
                            $menuName = $offer['menu_name'];
                            $discountPercentage = $offer['discount_percentage'];
                            $startTime = $offer['start_time'];
                            $endTime = $offer['end_time'];
                            ?>

                            <tr>
                                <th id="offerID-<?= $offerID ?>"><?= $offerID ?></th>
                                <td id="restaurantName-<?= $offerID ?>"><?= $restaurantName ?></td>
                                <td id="menuName-<?= $offerID ?>"><?= $menuName ?></td>
                                <td id="discountPercentage-<?= $offerID ?>"><?= $discountPercentage ?>%</td>
                                <td id="startTime-<?= $offerID ?>"><?= $startTime ?></td>
                                <td id="endTime-<?= $offerID ?>"><?= $endTime ?></td>
                                <td>
                                    <button type="button" class="btn btn-secondary" onclick="updateOffer('<?= $offerID ?>')"><i class="fa-solid fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger" onclick="deleteOffer('<?= $offerID ?>')"><i class="fa-solid fa-trash"></i></button>
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
<script src="assets/js/page-transition.js"></script>

<script>
function updateOffer(id) {
    $("#updateOfferModal").modal("show");

    let updateOfferID = $("#offerID-" + id).text();
    let updateRestaurantName = $("#restaurantName-" + id).text();
    let updateMenuName = $("#menuName-" + id).text();
    let updateDiscountPercentage = $("#discountPercentage-" + id).text().replace('%', '');
    let updateStartTime = $("#startTime-" + id).text();
    let updateEndTime = $("#endTime-" + id).text();

    $("#updateOfferID").val(updateOfferID);
    $("#updateRestaurantName").val(updateRestaurantName);
    $("#updateMenuName").val(updateMenuName);
    $("#updateDiscountPercentage").val(updateDiscountPercentage);
    $("#updateStartTime").val(updateStartTime);
    $("#updateEndTime").val(updateEndTime);
}

function deleteOffer(id){
    if(confirm("Do you confirm to delete this offer?")){
        window.location="endpoint/delete-offer.php?offer="+id;
    }
}
</script>

</body>
</html>
