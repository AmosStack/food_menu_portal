<?php
session_start();
error_reporting(0);
include('conn/conn.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $newpassword = md5($_POST['newpassword']);

    $sql = "SELECT MobileNumber FROM tbl_admin WHERE email=:email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $updatePassword = "UPDATE tbluser SET Password=:newpassword WHERE email=:email";
        $chngpwd1 = $dbh->prepare($updatePassword);
        $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();

        echo "<script>alert('Your password has been successfully changed.');</script>";
    } else {
        echo "<script>alert('Invalid email ID or mobile number.');</script>";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Online Birth Certificate System</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="assets/css/page-transition.css">

    <!-- JavaScript Validation -->
    <script>
        function valid() {
            const newPassword = document.chngpwd.newpassword.value;
            const confirmPassword = document.chngpwd.confirmpassword.value;

            if (newPassword !== confirmPassword) {
                alert("New Password and Confirm Password fields do not match!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>

<body class="materialdesign">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center text-primary">Food Menu and Pricing Portal</h3>
                        <hr>
                        <h4 class="text-center text-secondary">Forgot Password</h4>
                        <form class="mt-4" method="post" name="chngpwd" onsubmit="return valid();">
