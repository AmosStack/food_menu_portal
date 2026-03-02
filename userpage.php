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
    <title>Food Menu and Pricing Portal | Ardhi</title>

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



        section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: none;
        }

        .home-container {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 1100px;
            color: rgb(255, 255, 255);
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            padding: 40px;
            text-shadow: 2px 2px rgb(100, 100, 100);
            background-color: rgba(0, 0, 0, 0.4);
            margin-top: 10px;
        }

        .home-container > img {
            width: 150px;
        }

        .home-container > h1 {
            font-size: 90px;
            font-weight: bold;
        }

        .home-container > p {
            font-size: 25px;
        }

        .contact-us-container {
            width: 1100px;
            color: rgb(255, 255, 255);
            text-shadow: 2px 2px rgb(100, 100, 100);
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            margin-top: 64px;
        }

        .contact-container > div {
            padding: 30px;
        }

        .details-container {
            background-color: rgba(0, 0, 0, 0.4);
            padding: 50px;
        }

        .details-container > p {
            margin: 10px;
        }

        .details-container > h6 {
            margin: 25px;
        }

        .social {
            margin: 10px 35px;
        }
        
        .social > i {
            font-size: 25px;
            margin-right: 15px;
        }

        .form-container {
            padding: 50px;
        }

        .food-menu-container {
            display: flex;
            flex-direction: column;
            width: 1200px;
            height: 720px;
            margin-top: 50px;
            color: rgb(255, 255, 255);
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .menus {
            display: flex;
            flex-wrap: wrap;
            overflow: auto;
        }

        .card {
            margin: 19px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand ml-5" href="gallery.html">Food Menu and Pricing Portal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav mr-auto my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px; margin-left: 80%;">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                My Account
                </a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="offers.php">Offers</a></li>
                <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                </ul>
            </li>

            </ul>

        </div>
    </nav>

    <div class="main">

        <div data-spy="scroll" data-target="#navbar-header" data-offset="0">

            <section id="home">
            <div class="home-container row">
                <img src="" alt="">
                <h1>Welcome to Food Menu and Pricing Portal</h1>
                <p>Explore a world of culinary delights with our Food Menus. Whether you're a food enthusiast or a restaurant owner, our platform is designed to enhance your dining experience. Discover a diverse range of dishes, from savory classics to innovative creations, curated to satisfy every palate. Join us on a gastronomic journey where flavor meets convenience, and let Food Menu redefine the way you experience food.</p>
            </div>
            </section>

            <section id="restaurants">
                <div class="food-menu-container">
                    <h1 class="text-center">Our Restaurants</h1>

                    <div class="menus">

                        <?php 
                            
                            $stmt = $conn->prepare("SELECT * FROM `tbl_restaurants`");
                            $stmt->execute();

                            $result = $stmt->fetchAll();

                            foreach($result as $row) {
                                $image = $row['image'];
                                $restaurantName = $row['restaurant_name'];
                                $address = $row['address'];
                                $description = $row['description'];
                                $restaurantImageSrc = resolveImagePath($image);
                                ?>


                            <div class="card" style="width: 15rem; background-color:rgba(0,0,0,0.5);" >
                                <img src="<?= htmlspecialchars($restaurantImageSrc) ?>" class="card-img-top" alt="..." style="height:150px;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $restaurantName ?></h5>
                                    <p class="card-text">Description: <?= $description ?></p>
                                </div>
                                <div class="card-footer">
                                    ADDRESS: <?= $address ?>
                                </div>
                            </div>

                                <?php
                            }
                        ?>

                    </div>
                </div>
            </section>

            <section id="foodMenu">
                <div class="food-menu-container">
                    <h1 class="text-center">Our Food Menu</h1>

                    <div class="menus">

                        <?php 
                            
                            $stmt = $conn->prepare("SELECT * FROM `tbl_menu`");
                            $stmt->execute();

                            $result = $stmt->fetchAll();

                            foreach($result as $row) {
                                $image = $row['image'];
                                $menuName = $row['menu_name'];
                                $price = $row['price'];
                                $description = $row['description'];
                                $menuImageSrc = resolveImagePath($image);
                                ?>


                            <div class="card" style="width: 15rem; background-color:rgba(0,0,0,0.5);" >
                                <img src="<?= htmlspecialchars($menuImageSrc) ?>" class="card-img-top" alt="..." style="height:150px;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $menuName ?></h5>
                                    <p class="card-text">Description: <?= $description ?></p>
                                </div>
                                <div class="card-footer">
                                    Price: <?= $price ?>
                                </div>
                            </div>

                                <?php
                            }
                        ?>

                    </div>
                </div>
            </section>

            <section id="contactUs">
                <div class="contact-us-container row">

                <div class="details-container col-6">
                    <h1>Contact Us</h1>
                    <p>Have questions, feedback, or just want to say hello? We'd love to hear from you! Reach out to us through the following channels:</p>

                    <h6><span><i class="fa-solid fa-envelope"></i></span> Email: info@foodmenuportal.com</h6>

                    <h6><span><i class="fa-solid fa-phone"></i></span> Phone: +255 753 052 925</h6>

                    <h6><span><i class="fa-solid fa-location-dot"></i></span> Address: Ardhi University, DSM, TZ</h6>

                    <div class="social">
                        <i class="fa-brands fa-facebook"></i>
                        <i class="fa-brands fa-twitter"></i>
                        <i class="fa-brands fa-linkedin"></i>
                        <i class="fa-brands fa-square-instagram"></i>
                    </div>
                </div>

                <div class="col-lg-6 form">
                    <form action="contact.php" method="POST" class="php-email-form">
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>

                            <div class="col-md-6 ">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message"
                                    required></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" name="submit">Send Feedback</button>
                            </div>

                        </div>
                    </form>

                </div>



            </section>


    </div>

    <!-- Bootstrap JS -->
    <!-- Replace the slim version with the full version of jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function(){
            // Add active class to navbar links on click
            $(".navbar-nav a").on("click", function(){
                $(".navbar-nav").find(".active").removeClass("active");
                $(this).parent().addClass("active");
            });
        });
    </script>
    <script src="assets/js/page-transition.js"></script>
</body>
</html>
