<?php
session_start();
$googleOAuthConfig = include __DIR__ . '/google-oauth-config.php';
$googleClientId = trim($googleOAuthConfig['google_client_id'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Food Menu and Pricing Portal | Ardhi</title>
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
      include "connection.php";

      if (isset($_POST['login'])) {

        $email = $_POST['email'];
        $pass = $_POST['password'];

        $sql = "select * from tbl_users where email='$email'";

        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {

          $row = mysqli_fetch_assoc($res);

          $password = $row['password'];

          $decrypt = password_verify($pass, $password);


          if ($decrypt) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("location: userpage.php");


          } else {
            echo "<div class='message'>
                    <p>Wrong Password</p>
                    </div><br>";

            echo "<a href='login.php'><button class='btn'>Go Back</button></a>";
          }

        } else {
          echo "<div class='message'>
                    <p>Wrong Email or Password</p>
                    </div><br>";

          echo "<a href='login.php'><button class='btn'>Go Back</button></a>";

        }


      } else {


        ?>

        <header> UserLogin</header>
        <hr>
        <form action="#" method="POST">

          <div class="form-box">


            <div class="input-container">
              <i class="fas fa-envelope icon"></i>
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


          <center><input type="submit" name="login" id="submit" value="login" class="btn"></center>
          <center style="margin-top: 10px;">
            <?php if ($googleClientId !== ''): ?>
              <div id="g_id_onload"
                data-client_id="<?= htmlspecialchars($googleClientId) ?>"
                data-callback="handleGoogleCredential"
                data-auto_prompt="false">
              </div>
              <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline" data-text="signin_with" data-shape="rectangular" data-logo_alignment="left"></div>
            <?php else: ?>
              <small>Google sign-in is not configured yet.</small>
            <?php endif; ?>
          </center>

          <div class="links">
            Don't have an account? <a href="signup.php">Signup Now</a></br>
            <a href="index.php">Home</a>
          </div>

        </form>
      </div>
      <?php
      }
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

    async function handleGoogleCredential(response) {
      try {
        const request = await fetch("google-login.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({ credential: response.credential })
        });

        const result = await request.json();

        if (result.success) {
          window.location.href = result.redirect || "userpage.php";
          return;
        }

        alert(result.message || "Google login failed.");
      } catch (error) {
        alert("Google login failed. Please try again.");
      }
    }
  </script>
  <script src="https://accounts.google.com/gsi/client" async defer></script>
  <script src="assets/js/page-transition.js"></script>
</body>

</html>