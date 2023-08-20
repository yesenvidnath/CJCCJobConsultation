<?php
  include('template_parts/header-footer/header.php');
  //Connnection methode
  include('connect.php');
?>

<section class="admin-dashbord-section">

    <div class="container">

        <div class="row">

            <div class="col-md-9">

                <div class="container mt-5">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="card mb-3" >
                                <div class="row g-0">
                                    <div class="card-body">

                                        <?php 
                                            // Query to get the total number of users
                                            $sql = "SELECT COUNT(*) AS totalUsers FROM users";
                                            $result = $conn->query($sql);

                                            if ($result && $result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $totalUsers = $row['totalUsers'];
                                            } else {
                                                $totalUsers = 0;
                                            }
                                            // Close the database connection
                                            $conn->close();
                                        ?>

                                        <div class="count-wrap">
                                            <span class="count-custom"><i class="fas fa-dot-circle"></i> Total Users <?php echo $totalUsers; ?></span>
                                        </div>
                                        
                                        <center>

                                            <h5 class="card-title"> Users </h5>
                                            <p class="card-text"> Manage All users  </p>
                                            <br><br>

                                            <a href="admin_user_management.php" class="btn btn-outline-success"> <i class="fas fa-pencil"></i> Edit Now </a>

                                        </center>
                                    </div>


                                </div>    
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3" >
                                <div class="row g-0">
                                    <div class="card-body">
                                        <?php 
                                          include('connect.php');

                                            // Query to get the total number of users
                                            $sql = "SELECT COUNT(*) AS totalApplicants FROM applicants";
                                            $results = $conn->query($sql);

                                            if ($results && $results->num_rows > 0) {
                                                $row = $results->fetch_assoc();
                                                $totalApplicants = $row['totalApplicants'];
                                            } else {
                                                $totalApplicants = 0;
                                            }
                                            // Close the database connection
                                           $conn->close();
                                        ?>


                                        <div class="count-wrap">
                                            <span class="count-custom"><i class="fas fa-dot-circle"></i> Total Aplicants <?php echo $totalApplicants; ?></span>
                                        </div>  

                                        <center>

                                            <h5 class="card-title"> Aplicants  </h5>
                                            <p class="card-text"> Manage All Aplicants  </p>
                                            <br><br>

                                            <a href="admin_aplicants_management.php" class="btn btn-outline-success"> <i class="fas fa-pencil"></i> Edit Now </a>
                                        </center>
                                    </div>
                                </div>    
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3" >
                                <div class="row g-0">
                                    <div class="card-body">

                                        <?php 
                                          include('connect.php');
                                          
                                            // Query to get the total number of users
                                            $sql = "SELECT COUNT(*) AS totalconsultants FROM consultant";
                                            $results1 = $conn->query($sql);

                                            if ($results1 && $results->num_rows > 0) {
                                                $row = $results1->fetch_assoc();
                                                $totalconsultants = $row['totalconsultants'];
                                            } else {
                                                $totalconsultants = 0;
                                            }
                                            // Close the database connection
                                           $conn->close();
                                        ?>

                                        <div class="count-wrap">
                                            <span class="count-custom"><i class="fas fa-dot-circle"></i> Total Consultants <?php echo $totalconsultants; ?></span>
                                        </div>

                                        <center>

                                            <h5 class="card-title">  Consultants </h5>
                                            <p class="card-text"> Manage All Consultants  </p>
                                            <br><br>
                                            
                                            <a href="admin_consultants_management.php" class="btn btn-outline-success"> <i class="fas fa-pencil"></i> Edit Now </a>

                                        </center>
                                    </div>
                                </div>    
                            </div>
                        </div>

                    </div>


                    
                    <div class="row">

                        <div class="col-md-4">
                            <div class="card mb-3" >
                                <div class="row g-0">
                                    <div class="card-body">

                                        <?php 
                                            include('connect.php');
                                            // Query to get the total number of users
                                            $sql = "SELECT COUNT(*) AS totalconsult_appointment FROM consult_appointment";
                                            $result3 = $conn->query($sql);

                                            if ($result3 && $result3->num_rows > 0) {
                                                $row = $result3->fetch_assoc();
                                                $totalconsult_appointment = $row['totalconsult_appointment'];
                                            } else {
                                                $totalconsult_appointment = 0;
                                            }
                                            // Close the database connection
                                            $conn->close();
                                        ?>

                                        <div class="count-wrap">
                                            <span class="count-custom"><i class="fas fa-dot-circle"></i> Total Appointments <?php echo $totalconsult_appointment; ?></span>
                                        </div>
                                        <center>

                                            <h5 class="card-title"> Appointments </h5>
                                            <p class="card-text"> Manage All Appointments </p>
                                            <br><br>
                                            
                                            <a href="admin_appointments_management.php" class="btn btn-outline-success"> <i class="fas fa-pencil"></i> Edit Now </a>
                                        </center>
                                    </div>
                                </div>    
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3" >
                                <div class="row g-0">
                                    <div class="card-body">
                                        <?php 
                                            include('connect.php');

                                            // Query to get the total number of users
                                            $sql = "SELECT COUNT(*) AS totalinvoices FROM invoices";
                                            $results4 = $conn->query($sql);

                                            if ($results4 && $results4->num_rows > 0) {
                                                $row = $results4->fetch_assoc();
                                                $totalinvoices = $row['totalinvoices'];
                                            } else {
                                                $totalinvoices = 0;
                                            }
                                            // Close the database connection
                                        $conn->close();
                                        ?>


                                        <div class="count-wrap">
                                            <span class="count-custom"><i class="fas fa-dot-circle"></i> Total invoices <?php echo $totalinvoices; ?></span>
                                        </div>  

                                        <center>

                                            <h5 class="card-title"> invoices  </h5>
                                            <p class="card-text"> Manage All invoices  </p>
                                            <br><br>
                                            
                                            <a href="admin_invoice_management.php" class="btn btn-outline-success"> <i class="fas fa-pencil"></i> Edit Now </a>
                                        </center>
                                    </div>
                                </div>    
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3" >
                                <div class="row g-0">
                                    <div class="card-body">

                                        <?php 
                                        include('connect.php');
                                        
                                            // Query to get the total number of users
                                            $sql = "SELECT COUNT(*) AS totaljobs FROM jobs";
                                            $results5 = $conn->query($sql);

                                            if ($results5 && $results5->num_rows > 0) {
                                                $row = $results5->fetch_assoc();
                                                $totaljobs = $row['totaljobs'];
                                            } else {
                                                $totaljobs = 0;
                                            }
                                            // Close the database connection
                                        $conn->close();
                                        ?>

                                        <div class="count-wrap">
                                            <span class="count-custom"><i class="fas fa-dot-circle"></i> Total Jobs <?php echo $totaljobs; ?></span>
                                        </div>

                                        <center>

                                            <h5 class="card-title">  Jobs </h5>
                                            <p class="card-text"> Manage All jobs  </p>
                                            <br><br>
                                            
                                            <a href="admin_job_management.php" class="btn btn-outline-success"> <i class="fas fa-pencil"></i> Edit Now </a>
                                        </center>

                                    </div>
                                </div>    
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-3 justify-content-center">

                <?php
                    include 'connect.php';
                    // Fetch the logged-in user's details from the Consultant table
                    $userId = $_SESSION['user_id'];
                    $sql = "SELECT * FROM admin WHERE User_ID = $userId";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $AdminID = $row['Admin_ID'];
                        $ADName = $row['AD_Name'];
                        $ADEmail = $row['AD_Email'];
                        $ADDiscription = $row['AD_Discription'];
                        // Add more fields as needed
                    } else {
                        // Handle the case when the user's details are not found
                        echo "User details not found.";
                    }
                    
                    // Close the database connection
                    $conn->close();
                ?>

                <!-- Card Section -->
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">

                        <div class="card-body">
                            <center>
                            <img src="assets/other/user.png" style="width:50%;" class="img-thumbnail rounded-circle" alt="Admin Image">
                            <br><br>
                            <h5 class="card-title"><?php echo $ADName ?></h5>
                            <p class="card-text"><strong>Email:</strong> <?php echo $ADEmail; ?></p>
                            <p class="card-text"><strong>Discription:</strong> <?php echo $ADDiscription; ?></p>
                            <!-- Add more fields as needed -->
                            </center>
                        </div>

                    </div>
                </div>

                <!-- End of Card Section -->
            </div>
        </div>

    </div>

</section>



<?php
  include('template_parts/header-footer/footer-admin.php');
?>
<script src="js/pop.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.6/dist/umd/popper.min.js"></script>