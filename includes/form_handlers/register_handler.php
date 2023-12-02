<?php

// Declaring Variables
global $con;
$fname = "";        // First Name
$lname = "";        // Last Name
$em = "";           // Email
$em2 = "";          // Email 2
$password = "";     // Password
$password2 = "";    // Password 2
$date = "";         // Sign up date
$error_array = array();  // Handles error messages

if (isset($_POST['register_button'])) {
// Register form values

// First name
    $fname = strip_tags($_POST['reg_fname']);    // Strip_tags removes hasty html tags
    $fname = str_replace(' ', '', $fname); // removes spaces from fname
    $fname = ucfirst(strtolower($fname)); // Only Capitalizes first letter
    $_SESSION['reg_fname'] = $fname; // Stores first name into session variable

// Last name
    $lname = strip_tags($_POST['reg_lname']);    // Strip_tags removes hasty html tags
    $lname = str_replace(' ', '', $lname); // removes spaces from lname
    $lname = ucfirst(strtolower($lname)); // Only Capitalizes first letter
    $_SESSION['reg_lname'] = $lname; // Stores last name into session variable

// Email
    $em = strip_tags($_POST['reg_email']);    // Strip_tags removes hasty html tags
    $em = str_replace(' ', '', $em); // removes spaces from email
    $em = ucfirst(strtolower($em)); // Only Capitalizes first letter
    $_SESSION['reg_email'] = $em; // Stores email into session variable

// Email 2
    $em2 = strip_tags($_POST['reg_email2']);    // Strip_tags removes hasty html tags
    $em2 = str_replace(' ', '', $em2); // removes spaces from email2
    $em2 = ucfirst(strtolower($em2)); // Only Capitalizes first letter
    $_SESSION['reg_email2'] = $em2; // Stores email 2 into session variable

// Password 1 & 2
    $password = strip_tags($_POST['reg_password']);    // Strip_tags removes hasty html tags
    $password2 = strip_tags($_POST['reg_password2']);    // Strip_tags removes hasty html tags

    $date = date("Y-m-d"); // This gets the current date

    if ($em == $em2) {
// Check if email is in valid format
        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

// Count the number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if ($num_rows > 0) {
                array_push($error_array, "Email is already in use<br>");
            }
        } else {
            array_push($error_array, "Invalid email format<br>");
        }
    } else {
        array_push($error_array, "Emails don't match<br>");
    }
    if (strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }
    if (strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
    }

    if ($password != $password2) {
        array_push($error_array, "Your passwords do not match<br>");
    } else {
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your password can only contain english characters or numbers<br>");
        }
    }
    if (strlen($password) > 30 || strlen($password) < 5) {
        array_push($error_array, "Your password must be between 5 and 30 characters<br>");
    }

    if (empty($error_array)) {
        $password = md5($password);  // Encrypt password before sending to database

// Generate username by concatenating first name and last name
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

        $i = 0;
// if username exists add number to username
        while (mysqli_num_rows($check_username_query) != 0) {
            $i++; // Add one to $i .....  $i++ is the same as $i = $1 + 1;
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }

// Profile Picture assignment
        $rand = rand(1, 16); // random number between 1 and 16

// Profile Picture assignment
        $rand = rand(1, 16); // random number between 1 and 16

        switch ($rand) {
            case 1:
                $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
                break;
            case 2:
                $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";
                break;
            case 3:
                $profile_pic = "assets/images/profile_pics/defaults/head_red.png";
                break;
            case 4:
                $profile_pic = "assets/images/profile_pics/defaults/head_pumpkin.png";
                break;
            case 5:
                $profile_pic = "assets/images/profile_pics/defaults/head_belize_hole.png";
                break;
            case 6:
                $profile_pic = "assets/images/profile_pics/defaults/head_turquoise.png";
                break;
            case 7:
                $profile_pic = "assets/images/profile_pics/defaults/head_sun_flower.png";
                break;
            case 8:
                $profile_pic = "assets/images/profile_pics/defaults/head_wisteria.png";
                break;
            case 9:
                $profile_pic = "assets/images/profile_pics/defaults/head_wet_asphalt.png";
                break;
            case 10:
                $profile_pic = "assets/images/profile_pics/defaults/head_peter_river.png";
                break;
            case 11:
                $profile_pic = "assets/images/profile_pics/defaults/head_green_sea.png";
                break;
            case 12:
                $profile_pic = "assets/images/profile_pics/defaults/head_carrot.png";
                break;
            case 13:
                $profile_pic = "assets/images/profile_pics/defaults/head_amethyst.png";
                break;
            case 14:
                $profile_pic = "assets/images/profile_pics/defaults/head_nephritis.png";
                break;
            case 15:
                $profile_pic = "assets/images/profile_pics/defaults/head_alizarin.png";
                break;
            case 16:
                $profile_pic = "assets/images/profile_pics/defaults/head_pomegranate.png";
                break;
            default:
                break;
        }
        $query = mysqli_query(
            $con,
            "INSERT INTO users VALUES (NULL, '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')"
        );

        array_push($error_array, "<span style='color: #14C800'>You're all set! Go ahead and login!</span><br>");

// Clear session variables
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";
    }
}