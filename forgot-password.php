<?php
session_start();
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password | Food Menu and Pricing Portal | Ardhi</title>
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/page-transition.css">

  <style>
    body {
      background-image: url('images/background.jpg');
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="form-box box">

      <?php
      if (isset($_POST['reset'])) {
        $email = trim($_POST['email']);
        $newPassword = $_POST['newpassword'];
        $confirmPassword = $_POST['confirmpassword'];

        if ($newPassword !== $confirmPassword) {
          echo "<div class='message'>
                  <p>New Password and Confirm Password do not match.</p>
                </div><br>";
          echo "<a href='forgot-password.php'><button class='btn'>Go Back</button></a>";
        } else {
          $checkStmt = $conn->prepare("SELECT id FROM tbl_users WHERE email = ? LIMIT 1");
          $checkStmt->bind_param("s", $email);
          $checkStmt->execute();
          $result = $checkStmt->get_result();

          if ($result->num_rows > 0) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateStmt = $conn->prepare("UPDATE tbl_users SET password = ? WHERE email = ?");
            $updateStmt->bind_param("ss", $hashedPassword, $email);

            if ($updateStmt->execute()) {
              echo "<div class='message'>
                      <p>Password updated successfully!</p>
                    </div><br>";
              echo "<a href='login.php'><button class='btn'>Login Now</button></a>";
            } else {
              echo "<div class='message'>
                      <p>Unable to update password. Please try again.</p>
                    </div><br>";
              echo "<a href='forgot-password.php'><button class='btn'>Go Back</button></a>";
            }

            $updateStmt->close();
          } else {
            echo "<div class='message'>
                    <p>Email not found. Please use a registered email.</p>
                  </div><br>";
            echo "<a href='forgot-password.php'><button class='btn'>Go Back</button></a>";
          }

          $checkStmt->close();
        }
      } else {
      ?>

      <header>Forgot Password</header>
      <hr>
      <form action="#" method="POST">

        <div class="form-box">
          <div class="input-container">
            <i class="fa fa-envelope icon"></i>
            <input class="input-field" type="email" placeholder="Email Address" name="email" required>
          </div>

          <div class="input-container">
            <i class="fa fa-lock icon"></i>
            <input class="input-field password" type="password" placeholder="New Password" name="newpassword" required>
            <i class="fa fa-eye toggle icon"></i>
          </div>

          <div class="input-container">
            <i class="fa fa-lock icon"></i>
            <input class="input-field" type="password" placeholder="Confirm Password" name="confirmpassword" required>
          </div>
        </div>

        <center><input type="submit" name="reset" id="submit" value="Reset Password" class="btn"></center>

        <div class="links">
          Back to <a href="login.php">Login</a></br>
          <a href="index.php">Home</a>
        </div>

      </form>

      <?php
      }
      ?>
    </div>
  </div>

  <script>
    const toggle = document.querySelector(".toggle"),
      input = document.querySelector(".password");

    if (toggle && input) {
      toggle.addEventListener("click", () => {
        if (input.type === "password") {
          input.type = "text";
          toggle.classList.replace("fa-eye-slash", "fa-eye");
        } else {
          input.type = "password";
        }
      });
    }
  </script>
  <script src="assets/js/page-transition.js"></script>
</body>

</html>
