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
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" id="searchInput" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div id="searchResults" class="search-results"></div>

            <style>
                .search-results {
                    position: absolute;
                    top: 100%; /* Position below the search bar */
                    left: 40%;
                    width: 50%;
                    background-color: white;
                    /* border: 1px solid #ccc; */
                    display: none;
                    z-index: 1000;
                    padding: 60px 20px 30px 70px;
                    max-height: 600px;
                    overflow-y: scroll;
                    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
                    border-radius: 15px;
                }

                .search-result-cuntry{
                    padding: 5px 8px;
                    background: #28a745;
                    color: white;
                    border-radius: 5px;
                    font-size: 12px;
                    letter-spacing: 1px;
                }
                .search-result-cuntry:hover{
                    color: white !important;
                }

                .search-results .row{
                    padding-bottom: 20px;
                }

                .search-result {
                    display: block;
                    padding: 10px;
                    text-decoration: none;
                    color: #333;
                }

                .search-result:hover {
                    background-color: #f5f5f5;
                }

            </style>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const searchInput = document.getElementById("searchInput");
                    const searchResults = document.getElementById("searchResults");

                    // Show search results when input is focused and hide when it's blurred
                    searchInput.addEventListener("focus", function() {
                        searchResults.style.display = "block";
                    });

                    searchInput.addEventListener("blur", function() {
                        // Use setTimeout to give time for a click on the search results to register
                        setTimeout(function() {
                            searchResults.style.display = "none";
                        }, 200);
                    });

                    // Close search results when clicking somewhere else on the page
                    document.addEventListener("click", function(event) {
                        if (!searchResults.contains(event.target) && event.target !== searchInput) {
                            searchResults.style.display = "none";
                        }
                    });

                    // Handle search input changes and AJAX requests as before
                    searchInput.addEventListener("input", function() {
                        const searchTerm = searchInput.value.trim();

                        if (searchTerm === "") {
                            searchResults.innerHTML = "";
                            return;
                        }

                        const xhr = new XMLHttpRequest();
                        xhr.open("GET", `search.php?query=${searchTerm}`, true);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                searchResults.innerHTML = xhr.responseText;
                            }
                        };
                        xhr.send();
                    });
                });

            </script>
            <!-- Button -->
            <!-- Check wethere the user have logged in to the system or not, if the user is not logged in the login button will show else it will display the logout as a result -->
           <!-- ... Rest of the Nav Bar code ... -->

            <?php
                if (isset($_SESSION['user_id'])) {

                    include('connect.php');
                    $user_id = $_SESSION['user_id'];

                    $sql = "SELECT user_type FROM users WHERE user_id = $user_id";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $utypeofloggedin = $row['user_type'];

                        if ($utypeofloggedin === 'Admin') {
                            echo '<a class="btn btn-outline-success ml-2"href="Admin_dashbord.php">Admin Panel</a>';
                        } elseif ($utypeofloggedin === 'Consultant') {
                            echo '<a class="btn btn-outline-success ml-2" href="Consultant_dashbord.php">My Dashboard</a>';
                        } elseif ($utypeofloggedin === 'JobSeeker') {
                            echo '<a class="btn btn-outline-success ml-2" href="dashbord.php">My Dashboard</a>';
                        } else {
                            echo '<a class="btn btn-success ml-2" href="login.php">Sign In / Log In</a>';
                        }

                        echo '<a class="btn btn-success ml-2" href="logout.php">Logout</a>';
                    }else{
                        echo '<a class="btn btn-success ml-2" href="login.php">Sign In / Log In</a>';
                    }
                }else{
                    echo '<a class="btn btn-success ml-2" href="login.php">Sign In / Log In</a>';
                }
            ?>

        </div>
    </div>
</nav>

<!-- Nav Bar End -->