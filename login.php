<?php
  include('template_parts/header-footer/header.php');
  //Connnection methode
  include('connect.php');
?>
<!-- Login Methode Start -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login</title>
    
</head>
<body>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT User_ID, User_Type FROM Users WHERE User_Email = '$email' AND User_Password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['User_ID'];
        $user_type = $row['User_Type'];
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_type'] = $user_type;
    
        // Output JavaScript to redirect the user
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    } else {
        $loginError = "Invalid email or password.";
    }
    
}


// Handle sign up form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];
    $userType = $_POST['userType'];

    // Check if the email is already registered
    $sql = "SELECT User_ID FROM Users WHERE User_Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $signupError = "Email already registered. Please use a different email.";
    } else {
        // Insert new user data into the database
        $sql = "INSERT INTO Users (User_Type, User_Email, User_Password) VALUES ('$userType', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            // User registration successful, redirect to login page
            header('Location: login.php');
            exit();
        } else {
            // User registration failed, show error message or handle as needed
            $signupError = "Error creating user. Please try again later.";
        }
    }
}

$conn->close();
?>

<!-- Login Methode End -->

<section class="login-page-section">

    <div class="container">

        <div class="form-container">

            <div class="row">
                
                <div class="col-md-4 background-img">
                    <img src="assets/login_imgs/1.png" alt="">
                </div>

                <div class="col-md-8">
                    <h2>Login and Sign Up</h2>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Sign Up</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="loginEmail">Email address</label>
                                    <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Password</label>
                                    <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-success">Login</button>
                            </form>
                            <?php
                            if (isset($loginError)) {
                                echo '<p class="text-danger">' . $loginError . '</p>';
                            }
                            ?>
                        </div>

                        <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">

                            <form method="POST">
                                <!-- Sign Up form fields -->
                                <div class="form-group">
                                    <label for="userType">User Type</label>
                                    <select class="form-control" id="userType" name="userType">
                                        <option value="Consultant">Consultant</option>
                                        <option value="JobSeeker">Job Seeker</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="signupEmail">Email address</label>
                                    <input type="email" class="form-control" id="signupEmail" name="signupEmail" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="signupPassword">Password</label>
                                    <input type="password" class="form-control" id="signupPassword" name="signupPassword" placeholder="Password">
                                </div>

                                <button type="submit" name="signup" class="btn btn-success">Sign Up</button>
                            </form>
                            <?php
                            if (isset($signupError)) {
                                echo '<p class="text-danger">' . $signupError . '</p>';
                            }
                            ?>

                        </div>
                    </div>
                </div>

            </div>
    
        </div>
    </div>

</section>

<?php
  include('template_parts/header-footer/footer.php');
?>