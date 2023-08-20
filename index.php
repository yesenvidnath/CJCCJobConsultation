<?php
  include('template_parts/header-footer/header.php');
  //Connnection methode
  include('connect.php');
?>

<?php
    if (isset($_GET['message'])) {
        echo '<script>alert("' . $_GET['message'] . '");</script>';
    }

?>

<section class="slider-section">

    <!-- Image Slder Start-->

    <!-- Image Carousel -->
    <div id="myCarousel" class="carousel slide fixed-height" data-ride="carousel">
        <!-- Indicators -->
        <ul class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <!-- Add more indicators as needed for additional images -->
        </ul>
        
        <!-- Slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/slider_imgs/4.png" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="assets/slider_imgs/1.png" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="assets/slider_imgs/2.png" alt="Slide 3">
            </div>
            <div class="carousel-item">
                <img src="assets/slider_imgs/6.png" alt="Slide 3">
            </div>
            <div class="carousel-item">
                <img src="assets/slider_imgs/5.png" alt="Slide 3">
            </div>
            <div class="carousel-item">
                <img src="assets/slider_imgs/3.png" alt="Slide 3">
            </div>
            <!-- Add more carousel items for additional images -->
        </div>

        <!-- Controls -->
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>

        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Image Slder end-->

</section>

<section class="Job-cards-section">

    <div class="container mt-4">
        <div class="row">
            <?php
            // Fetch data from the Jobs table
            $sql = "SELECT Job_ID, Job_Title, Job_country, Job_Disc, Job_End_Date, Job_Image FROM Jobs";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Loop through the data and create Bootstrap cards
                while ($row = $result->fetch_assoc()) {
                    $jobId = $row["Job_ID"];
                    $jobTitle = $row["Job_Title"];
                    $jobCountry = $row["Job_country"];
                    $jobDescription = $row["Job_Disc"];
                    $jobEndDate = $row["Job_End_Date"];
                    $jobImage = $row["Job_Image"];
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo $jobImage; ?>" class="card-img-top" alt="Job Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $jobTitle; ?></h5>
                                <p class="card-text"><?php echo $jobCountry; ?></p>
                                <p class="card-text"><?php echo substr($jobDescription, 0, 50); ?>... <span class="read-more"><a href="#"  data-toggle="modal" data-target="#jobModal<?php echo $jobId; ?>">[More]</a></span></p>

                                <?php

                                    if (isset($_SESSION['user_id'])) {

                                        $sql = "SELECT user_type FROM users WHERE user_id = $user_id";
                                        $innerresult = $conn->query($sql);

                                        if ($innerresult && $innerresult->num_rows > 0) {
                                            $row = $innerresult->fetch_assoc();
                                            $utypeofloggedin = $row['user_type'];

                                            if ($utypeofloggedin === 'Admin') {
                                                echo '<a class="btn btn-outline-success disabled apply-now-btn" href="apply.php?job_id=' . $jobId . '">Apply Now</a>';
                                            } elseif ($utypeofloggedin === 'Consultant') {
                                                echo '<a class="btn btn-outline-success disabled apply-now-btn" href="apply.php?job_id=' . $jobId . '">Apply Now</a>';
                                            } elseif ($utypeofloggedin === 'JobSeeker') {
                                                echo '<a class="btn btn-outline-success apply-now-btn" href="apply.php?job_id=' . $jobId . '">Apply Now</a>';
                                            } else {
                                                echo '<a class="btn btn-outline-success apply-now-btn" href="login.php">Log in to Apply </a>';
                                            }
                                           
                                        }else{
                                            echo '<a class="btn btn-outline-success apply-now-btn" href="login.php">Log in to Apply </a>';
                                        }
                                    }

                                ?>

                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#jobModal<?php echo $jobId; ?>">View</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Add Modal for each job -->
                    <div class="modal fade" id="jobModal<?php echo $jobId; ?>" tabindex="-1" role="dialog" aria-labelledby="jobModalLabel<?php echo $jobId; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="jobModalLabel<?php echo $jobId; ?>"><?php echo $jobTitle; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-body-content">
                                        <div class="col-md-6">
                                            <img src="<?php echo $jobImage; ?>" class="img-fluid" alt="Job Image">
                                        </div>
                                        <div class="col-md-6">
                                            
                                            <p><strong>Country:</strong> <?php echo $jobCountry; ?></p>
                                            <p><strong>Description:</strong> <?php echo $jobDescription; ?></p>

                                            <?php

                                                if (isset($_SESSION['user_id'])) {

                                                    $sql = "SELECT user_type FROM users WHERE user_id = $user_id";
                                                    $innerresult = $conn->query($sql);

                                                    if ($innerresult && $innerresult->num_rows > 0) {
                                                        $row = $innerresult->fetch_assoc();
                                                        $utypeofloggedin = $row['user_type'];

                                                        if ($utypeofloggedin === 'Admin') {
                                                            echo '<a class="btn btn-outline-success disabled apply-now-btn" href="apply.php?job_id=' . $jobId . '">Apply Now</a>';
                                                        } elseif ($utypeofloggedin === 'Consultant') {
                                                            echo '<a class="btn btn-outline-success disabled apply-now-btn" href="apply.php?job_id=' . $jobId . '">Apply Now</a>';
                                                        } elseif ($utypeofloggedin === 'JobSeeker') {
                                                            echo '<a class="btn btn-outline-success apply-now-btn" href="apply.php?job_id=' . $jobId . '">Apply Now</a>';
                                                        } else {
                                                            echo '<a class="btn btn-outline-success apply-now-btn" href="login.php">Log in to Apply </a>';
                                                        }
                                                    
                                                    }else{
                                                        echo '<a class="btn btn-outline-success apply-now-btn" href="login.php">Log in to Apply </a>';
                                                    }
                                                }

                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "No jobs found.";
            }


            // Close the database connection
            $conn->close();
            ?>

        </div>
    </div>

</section>

    <!-- Add welcome popup -->
    <?php if (isset($loggedInUserType)) {
        // Include the database connection file to ensure the connection remains open
        include 'connect.php';

        // Retrieve the logged-in user's first name based on the user type
        $user_id = $_SESSION['user_id'];
        $user_first_name = '';
        $user_table = '';

        if ($loggedInUserType == 'Admin') {
            $user_table = 'Admin';
            $user_table_first_name = 'AD_Name'; 
        } elseif ($loggedInUserType == 'Consultant') {
            $user_table = 'Consultant';
            $user_table_first_name = 'Con_First_Name';
        } elseif ($loggedInUserType == 'JobSeeker') {
            $user_table = 'Applicants';
            $user_table_first_name = 'Appli_First_Name';
        }

        if (!empty($user_table)) {
            $sql = "SELECT {$user_table}.{$user_table_first_name} AS first_name
                    FROM Users
                    INNER JOIN {$user_table} ON Users.User_ID = {$user_table}.User_ID
                    WHERE Users.User_ID = $user_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user_first_name = $row['first_name'];
            }
        }
    ?>
        <div class="modal" id="welcomeModal" tabindex="-1" role="dialog" style="border-radius: 10px;">
            <div class="modal-dialog modal-dialog-centered" role="document" >
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #28A745; color: white; ">
                        <center><h5 class="modal-title">Welcome to CJCC <?php echo $loggedInUserType; ?></h5></center>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <img src="assets/login_imgs/correct.png" alt="" width="100%">
                        <!-- Add any message or content you want in the popup body -->
                        <!-- For example: -->
                        <center><h6>Hello <?php echo $user_first_name; ?>, thank you for logging in!</h6></center>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Script to show the welcome popup -->
        <script>
            $(document).ready(function() {
                $('#welcomeModal').modal('show');
            });
        </script>
    <?php } ?>

<?php
  include('template_parts/header-footer/footer.php');
?>