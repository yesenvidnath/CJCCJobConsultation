<?php
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        if (isset($_SESSION['user_type'])) {
            $loggedInUserType = $_SESSION['user_type'];
            // Remove the user type from the session so the popup is shown only once
            unset($_SESSION['user_type']);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <title>Colombo Job Consultation</title>
    
</head>
<body>

<!-- Nav Bar Start -->

<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-sticky">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <span class="logo-main">CJCC</span>
        </a>
        
        <!-- Toggle Button (for smaller screens) -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Links -->
            <ul class="navbar-nav mr-auto offset-1">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
            
            <!-- Search Bar -->
            <a class="btn btn-outline-success" href="admin_dashbord.php">Go Back</a>

           

        </div>
    </div>
</nav>

<!-- Nav Bar End -->