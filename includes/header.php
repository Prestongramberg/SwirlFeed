<?php

global $con;
require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");

if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
} else {
    header("Location: register.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swirlfeed</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/bootbox.min.js"></script>
    <script src="https://kit.fontawesome.com/1ff8f2d18f.js" crossorigin="anonymous"></script>
    <script src="assets/js/swirlfeed.js"></script>
    <script src="assets/js/jquery.jcrop.js"></script>
    <script src="assets/js/jcrop_bits.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css"/>
    <meta name="description" content="Social Media Project">
    <meta name="author" content="Preston Gramberg">
</head>
<body>
<div class="top_bar">
    <div class="logo">
        <a href="index.php">Swirlfeed</a>
    </div>
    <nav>
        <a href="<?php
        echo $userLoggedIn; ?>">
            <?php
            echo $user['first_name']; ?>
        </a>
        <a href="index.php"><i class="fa-solid fa-house-chimney"></i></a>
        <a href="javascript:void(0);" onclick="getDropdownData('<?php
        echo $userLoggedIn; ?>', 'message')"><i class="fa-solid fa-envelope"></i></a>
        <a href="#"><i class="fa-regular fa-bell"></i></a>
        <a href="requests.php"><i class="fa-solid fa-users"></i></a>
        <a href="#"><i class="fa-solid fa-bars"></i></a>
        <a href="includes/handlers/logout.php"><i class="fa-solid fa-sign-out"></i></a>
    </nav>

    <div class="dropdown_data_window"></div>
    <input type="hidden" id="dropdown_data_type" value="">

</div>
<div class="wrapper">
