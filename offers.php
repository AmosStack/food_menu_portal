<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>alert("You haven\'t logged in."); window.location.href = "login.php";</script>';
    exit();
}

include('conn/conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Management - User</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/page-transition.css">
    
    <style>
        body {
            background-image: url('img/bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            color: white;
            font-family: Arial, sans-serif;
            padding-top: 60px; /* Adjust based on your navbar height */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .offer-container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .offer-container h2 {
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .table {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            background-color: rgba(0, 0, 0, 0.6);
        }

        .table td {
            background-color: rgba(0, 0, 0, 0.9);
        }

        .btn {
            margin: 5px;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.8) !important;
        }

        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: rgba(255, 255, 255, 0.8) !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Offer Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home</a>
                </li>
                <?php
                if(isset($_SESSION['username'])) {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="userpage.php">Welcome, ' . $_SESSION['username'] . '</a>
                          </li>';
                } else {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                          </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>      
    
<div class="container">
    <div class="offer-container">
        <h2>Current Offers</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-dark">
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
                        $currentDateTime = date('Y-m-d H:i:s');
                        $stmt = $conn->prepare("SELECT tbl_offers.*, tbl_restaurants.restaurant_name, tbl_menu.menu_name 
                                                FROM tbl_offers
                                                JOIN tbl_restaurants ON tbl_offers.restaurant_id = tbl_restaurants.id
                                                JOIN tbl_menu ON tbl_offers.menu_id = tbl_menu.tbl_menu_id
                                                WHERE start_time <= ? AND end_time >= ?");
                        $stmt->execute([$currentDateTime, $currentDateTime]);

                        $result = $stmt->fetchAll();

                        foreach($result as $row) {
                            $offerID = $row['id'];
                            $restaurantName = $row['restaurant_name'];
                            $menuName = $row['menu_name'];
                            $discountPercentage = $row['discount_percentage'];
                            $startTime = $row['start_time'];
                            $endTime = $row['end_time'];
                            ?>

                            <tr>
                                <td><?= $offerID ?></td>
                                <td><?= $restaurantName ?></td>
                                <td><?= $menuName ?></td>
                                <td><?= $discountPercentage ?>%</td>
                                <td><?= $startTime ?></td>
                                <td><?= $endTime ?></td>
                                <td>
                                    <a href="userpage.php?action=comment&id=<?= $offerID ?>" class="btn btn-info btn-sm">Comment</a>
                                    <a href="userpage.php?action=ignore&id=<?= $offerID ?>" class="btn btn-danger btn-sm">Ignore</a>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script src="assets/js/page-transition.js"></script>

</body>
</html>
