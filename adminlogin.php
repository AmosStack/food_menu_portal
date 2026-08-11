<?php
session_start();
include "connection.php";

$message = "";

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $pass = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $res = $stmt->get_result();

  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $storedPassword = $row['password'];
    $isHashedPassword = password_get_info($storedPassword)['algo'] !== null;
    $passwordMatches = $isHashedPassword
      ? password_verify($pass, $storedPassword)
      : hash_equals($storedPassword, $pass);

    if ($passwordMatches) {
      if (!$isHashedPassword) {
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
        $updateStmt = $conn->prepare("UPDATE tbl_admin SET password = ? WHERE id = ?");
        $updateStmt->bind_param("si", $hashedPassword, $row['id']);
        $updateStmt->execute();
      }

      $_SESSION['id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      header("location: adminpage.php");
      exit;
    }

    $message = "Wrong Password";
  } else {
    $message = "Wrong Email or Password";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>adminLogin - Food Menu and Pricing Portal | Ardhi</title>
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/page-transition.css">
  <style>
    body{
      background-image: url('images/background.jpg');
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="form-box box">

      <?php
      if ($message !== "") {
        echo "<div class='message'><p>" . htmlspecialchars($message) . "</p></div><br>";
      }
      ?>

        <header>Admin Login</header>
        <hr>
        <form action="#" method="POST">

          <div class="form-box">


            <div class="input-container">
              <i class="fa fa-envelope icon"></i>
              <input class="input-field" type="email" placeholder="Email Address" name="email">
            </div>

            <div class="input-container">
              <i class="fa fa-lock icon"></i>
              <input class="input-field password" type="password" placeholder="Password" name="password">
              <i class="fa fa-eye toggle icon"></i>
            </div>

            <div class="remember">
              <input type="checkbox" class="check" name="remember_me">
              <label for="remember">Remember me</label>
              <span><a href="forgot-password.php">Forgot password</a></span>
            </div>

          </div>



          <center><input type="submit" name="login" id="submit" value="Login" class="btn"></center></br>
          <a href="index.php">Home</a>
          

        </form>
      </div>
      <?php
      ?>
  </div>
  <script>
    const toggle = document.querySelector(".toggle"),
      input = document.querySelector(".password");
    toggle.addEventListener("click", () => {
      if (input.type === "password") {
        input.type = "text";
        toggle.classList.replace("fa-eye-slash", "fa-eye");
      } else {
        input.type = "password";
      }
    })
  </script>
  <script src="assets/js/page-transition.js"></script>
</body>

</html>
