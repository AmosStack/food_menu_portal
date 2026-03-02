<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Messages</title>
    <link rel="stylesheet" href="./assets/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/page-transition.css">
    <style>
        body {
            background-image: url('img/bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            color: white;
            font-family: Arial, sans-serif;
            padding-top: 60px;
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

        .offer-container h4 {
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .table {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            color: white;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
            color: white;
        }

        .table th {
            background-color: rgba(0, 0, 0, 0.6);
        }

        .table td {
            background-color: rgba(0, 0, 0, 0.9);
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

        .dropdown-menu {
            background-color: rgba(0, 0, 0, 0.9);
        }

        .dropdown-item {
            color: white;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <div class="container">
        <a class="navbar-brand" href="#">Message Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                My Account
                </a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                </ul>
            </li>

            </ul>

        </div>
        </div>
    </nav>





<div class="container">
    <div class="offer-container">
        <h4>List of Messages</h4>
        <hr>
        <table class="table table-hover table-collapse">
            <thead>
                <tr>
                    <th scope="col">Message ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Message</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database credentials
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "food_menu_db";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare and execute the query
                $stmt = $conn->prepare("SELECT * FROM `tbl_contact`");
                $stmt->execute();
                $result = $stmt->get_result();

                // Fetch the results and display in the table
                while ($row = $result->fetch_assoc()) {
                    $messageID = $row['id'];
                    $name = $row['name'];
                    $email = $row['email'];
                    $subject = $row['subject'];
                    $message = $row['message'];
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($messageID); ?></td>
                        <td><?php echo htmlspecialchars($name); ?></td>
                        <td><?php echo htmlspecialchars($email); ?></td>
                        <td><?php echo htmlspecialchars($subject); ?></td>
                        <td><?php echo htmlspecialchars($message); ?></td>
                    </tr>
                <?php
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="assets/js/page-transition.js"></script>
</body>
</html>
