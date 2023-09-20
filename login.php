<?php
  include('template_parts/header-footer/header.php');
  //Connnection methode
  include('connect.php');
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
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

// Handle sign-up form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $skypeId = $_POST['skypeId'];
    $tpNo = $_POST['tpNo'];
    $dob = $_POST['dob'];
    $email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];

    // Check if the email is already registered
    $sql = "SELECT User_ID FROM Users WHERE User_Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $signupError = "Email already registered. Please use a different email.";
    } else {
        // Insert new user data into the Users table with User_Type set to "JobSeeker"
        $userType = "JobSeeker";
        $sql = "INSERT INTO Users (User_Type, User_Email, User_Password)
                VALUES ('$userType', '$email', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            // Get the User_ID of the newly created user
            $user_id = $conn->insert_id;
            $apliimagefixed = "assets/appli_imgs/test-img.jpg";
            // Insert job seeker (applicant) data into the Applicants table
            $sql = "INSERT INTO Applicants (User_ID, Appli_Img, Appli_First_Name, Appli_Last_Name, Appli_Address, Appli_Skype_ID, Appli_TP_No, Appli_DOB)
        VALUES ('$user_id', '$apliimagefixed', '$firstName', '$lastName', '$address', '$skypeId', '$tpNo', '$dob')";
            
            if ($conn->query($sql) === TRUE) {
                // Applicant registration successful, refresh the page
                $conn->close();
                echo '<script>window.location.reload();</script>';
                exit();
            } else {
                // Applicant registration failed, show error message or handle as needed
                $signupError = "Error creating applicant. Please try again later.";
            }
            
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

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="skypeId">Skype ID</label>
                                            <input type="text" class="form-control" id="skypeId" name="skypeId" placeholder="Enter Skype ID" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tpNo">TP Number</label>
                                            <input type="tel" class="form-control" id="tpNo" name="tpNo" placeholder="Enter TP number" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" name="dob" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="signupEmail">Email address</label>
                                            <input type="email" class="form-control" id="signupEmail" name="signupEmail" placeholder="Enter email" required>
                                        </div>
                                    </div>
                                    <!-- <div class="col-6">
                                        <div class="form-group">
                                            <label for="applicantImg">Applicant Image</label>
                                            <input type="file" class="form-control-file" id="applicantImg" name="applicantImg">
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="signupPassword">Password</label>
                                        <input type="password" class="form-control" id="signupPassword" name="signupPassword" placeholder="Password">

                                    </div>
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