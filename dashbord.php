<?php
  include('template_parts/header-footer/header.php');
  //Connnection methode
  include('connect.php');
?>

<section class="appli-dashbord-section">

    <div class="container">

        <div class="row">

            <div class="col-md-8">

                <div class="container mt-5">
                    <div class="row">
                        <!-- Left Sidebar with Nav Tabs -->
                        <div class="col-3">
                            <ul class="nav nav-tabs flex-column" id="dashboardTabs">
                                <!-- <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" href="#profile">Profile</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#applications">Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#settings">Consultations</a>
                                </li>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Invoice">My Payments</a>
                                </li>
                                <!-- Add more tabs as needed -->
                            </ul>
                        </div>

                            <!-- Right Content Area -->
                            <div class="tab-content" id="dashboardTabContent">
                                <!-- Profile Tab -->

                                <!-- Applications Tab -->
                                <div class="tab-pane fade show active" id="applications">
                                    <h3>Settings</h3>

                                    <?php
                                    // Fetch the logged-in user's details from the Applicants table
                                    $userId = $_SESSION['user_id'];
                                    $sql = "SELECT * FROM Applicants WHERE User_ID = $userId";
                                    $result = $conn->query($sql);

                                    if ($result && $result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $applicantId = $row['Appli_ID'];
                                        $firstName = $row['Appli_First_Name'];
                                        $lastName = $row['Appli_Last_Name'];
                                        $address = $row['Appli_Address'];
                                        $skypeId = $row['Appli_Skype_ID'];
                                        $tpNo = $row['Appli_TP_No'];
                                        $dob = $row['Appli_DOB'];
                                        $applicantImg = $row['Appli_Img'];
                                        // Add more fields as needed
                                    } else {
                                        // Handle the case when the user's details are not found
                                        echo "User details not found.";
                                    }
                                    ?>

                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="skypeId">Skype ID</label>
                                            <input type="text" class="form-control" id="skypeId" name="skypeId" value="<?php echo $skypeId; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tpNo">TP Number</label>
                                            <input type="tel" class="form-control" id="tpNo" name="tpNo" value="<?php echo $tpNo; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $dob; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="applicantImg">Applicant Image</label>
                                            <input type="file" class="form-control-file" id="applicantImg" name="applicantImg">
                                        </div>

                                        <!-- Add more fields as needed -->
                                        <button type="submit" class="btn btn-success">Save Changes</button>

                                    </form>

                                    <?php
                                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                        // Retrieve form data and sanitize if necessary
                                        $firstName = $_POST["firstName"];
                                        $lastName = $_POST["lastName"];
                                        $address = $_POST["address"];
                                        $skypeId = $_POST["skypeId"];
                                        $tpNo = $_POST["tpNo"];
                                        $dob = $_POST["dob"];
                                        // Process more fields as needed

                                        // Update the user's details in the database
                                        $sql = "UPDATE Applicants 
                                                SET Appli_First_Name = '$firstName', 
                                                    Appli_Last_Name = '$lastName',
                                                    Appli_Address = '$address',
                                                    Appli_Skype_ID = '$skypeId',
                                                    Appli_TP_No = '$tpNo',
                                                    Appli_DOB = '$dob',
                                                    Appli_Img = '$applicantImg'
                                                WHERE User_ID = $userId";

                                        if ($conn->query($sql) === TRUE) {
                                            // Update successful
                                            echo "Changes saved successfully.";
                                        } else {
                                            // Error updating
                                            echo "Error updating changes: " . $conn->error;
                                        }
                                    }
                                    ?>

                                </div>


                                <!-- Settings Tab -->
                                <div class="tab-pane fade" id="settings">

                                    <br><br>
                                    
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <?php
                                        // Fetch the consultations allocated to the applicant from the Consult_Appointment table
                                        include 'connect.php';
                                        $sql = "SELECT CA.CA_Apt_ID, CA.CA_Apt_Date, CA.CA_status, J.Job_Title, C.Con_First_Name, C.Con_Last_Name
                                                FROM Consult_Appointment AS CA
                                                JOIN Jobs AS J ON CA.Job_ID = J.Job_ID
                                                JOIN Consultant AS C ON CA.Con_ID = C.Con_ID
                                                WHERE CA.Appli_ID = $applicantId";
                                        $result = $conn->query($sql);

                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $aptId = $row['CA_Apt_ID'];
                                                $aptDate = $row['CA_Apt_Date'];
                                                $CA_status = $row['CA_status'];
                                                $jobTitle = $row['Job_Title'];
                                                $conFirstName = $row['Con_First_Name'];
                                                $conLastName = $row['Con_Last_Name']; 

                                                // Format the appointment date
                                                $formattedAptDate = date("M d, Y - h:i A", strtotime($aptDate));

                                                // Generate a unique ID for the modal using applicant ID and consultation ID
                                                $modalId = 'editModal' . $applicantId . '_' . $aptId . '_' . uniqid();

                                                // Display each consultation as a small card
                                                echo '<div class="col">';
                                                echo '<div class="card margin-bottom-custom">';
                                                echo '<div class="card-body ">';
                                                echo '<h5 class="card-title">' . $jobTitle . '</h5>';
                                                
                                                echo '<p class="card-text">';
                                                if (isset($CA_status)) {
                                                    if ($CA_status == 'Active') {
                                                        echo '<span class="active status-active"><i class="fas fa-dot-circle regular"></i> Active</span>';
                                                    } else {
                                                        echo '<span class="cancelled status-cancelled"><i class="fas fa-dot-circle regular"></i> Cancelled</span>';
                                                    }
                                                } else {
                                                    echo 'Status: ' . $CA_status;
                                                }
                                                echo '</p>';

                                                echo '<p class="card-text">Consultant: ' . $conFirstName . ' ' . $conLastName . '</p>';
                                                echo '<p class="card-text">Date: ' . $formattedAptDate . '</p>';
                                                echo '<button type="button" class="btn btn-outline-success" onclick="openEditModal(\'' . $modalId . '\')"> <i class="fas fa-pencil"></i> Edit</button>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';

                                                // Modal Popup for Editing Appointment Details
                                                echo '<div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-labelledby="' . $modalId . 'Label" aria-hidden="true">';
                                                echo '<div class="modal-dialog modal-dialog-centered">';
                                                echo '<div class="modal-content">';
                                                echo '<div class="modal-header">';
                                                echo '<h5 class="modal-title" id="' . $modalId . 'Label">Edit Appointment</h5>';
                                                echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                                                echo '</div>';
                                                echo '<div class="modal-body">';
                                                // Edit appointment form with time and date fields
                                                echo '<form action="./funtions/applicant/update_consultation.php" method="POST" class="mb-3">';
                                                echo '<input type="hidden" name="apt_id" value="' . $aptId . '">';
                                                echo '<div class="form-group">';
                                                echo '<label for="aptDate' . $aptId . '">Appointment Date:</label>';
                                                echo '<input type="datetime-local" class="form-control" id="aptDate' . $aptId . '" name="apt_date" value="' . $aptDate . '" required>';
                                                echo '</div>';
                                                // Add more fields as needed
                                                echo '<div class="modal-footer" style="margin:0; padding:0;">';
                                                echo '<button  type="submit"  style="width:100%; margin:0;" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>';
                                                echo '</div>';
                                                echo '</form>';

                                                echo '<p class="card-text">';
                                                if (isset($CA_status)) {

                                                    if ($CA_status == 'Active') {
                                                        echo '<form action="./funtions/applicant/cancel_consultation.php" style="width:100%; margin:0;" method="POST" class="d-inline-block">
                                                        <input type="hidden" name="apt_id" value="' . $aptId . '">
                                                        <button style="width:100%; margin:0;" type="submit" class="btn btn-secondary" onclick="return confirm(\'Are you sure you want to Cancel this consultation?\')"><i class="fas fa-trash"></i> Cancel Now</button>
                                                        </form>';
                                                    } else {
                                                        echo '<form action="./funtions/applicant/active_consultation.php" style="width:100%; margin:0;" method="POST" class="d-inline-block">
                                                        <input type="hidden" name="apt_id" value="' . $aptId . '">
                                                        <button style="width:100%; margin:0;" type="submit" class="btn btn-secondary" onclick="return confirm(\'Are you sure you want to Active this consultation?\')"><i class="fas fa-check"></i> Active Now</button>
                                                        </form>';
                                                    }
                                                } else {
                                                    echo 'Can Be an Error 😒';
                                                }
                                                echo '</p>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        } else {
                                            echo '<p>No consultations found.</p>';
                                        }

                                        // Close the database connection
                                        $conn->close();

                                        
                                        ?>
                                    </div>

                                </div>
                                <!-- Add more tab panes as needed -->
                                <div class="tab-pane fade show active" id="Invoice">
                                    <h3>My Invoices</h3>
                                    <br><br>
                                    <?php
                                        // Fetch the invoices belonging to the user from the Invoices table
                                        include 'connect.php';

                                        $sql = "SELECT I.Inv_ID, I.Inv_Date, I.Inv_Amount, J.Job_Title, C.Con_First_Name, C.Con_Last_Name
                                            FROM Invoices AS I
                                            JOIN Jobs AS J ON I.Job_ID = J.Job_ID
                                            JOIN Consultant AS C ON I.Con_ID = C.Con_ID
                                            WHERE I.User_ID = $user_id;
                                            ";
                                        $result = $conn->query($sql);

                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $invId = $row['Inv_ID'];
                                                $invDate = $row['Inv_Date'];
                                                $invAmount = $row['Inv_Amount'];
                                                $jobTitle = $row['Job_Title'];
                                                $conFirstName = $row['Con_First_Name'];
                                                $conLastName = $row['Con_Last_Name'];

                                                // Format the invoice date
                                                $formattedInvDate = date("M d, Y", strtotime($invDate));

                                                // Generate a unique ID for the modal using invoice ID
                                                $modalId = 'invoiceModal_' . $invId . '_' . uniqid();

                                                // Display each invoice as a card
                                                echo '<div class="col">';
                                                echo '<div class="card margin-bottom-custom">';
                                                echo '<div class="card-body">';
                                                echo '<h5 class="card-title">' . $jobTitle . '</h5>';
                                                echo '<br/>';
                                                echo '<p class="card-text">';
                                                echo '<strong>Invoice ID:</strong> ' . $invId . '<br>';
                                                echo '<br/>';
                                                echo '<strong>Invoice Date:</strong> ' . $formattedInvDate . '<br>';
                                                echo '<br/>';
                                                echo '<strong>Consultant:</strong> ' . $conFirstName . ' ' . $conLastName . '<br>';
                                                echo '<br/>';
                                                echo '<strong>Amount:</strong> $' . $invAmount . '<br>';
                                                echo '<br/>';
                                                // Add a button to view the invoice details in a modal
                                                echo '<button style="width:100%" type="button" class="btn btn-success" data-toggle="modal" data-target="#' . $modalId . '">View Invoice</button>';
                                                
                                                echo '</p>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                                
                                                // Modal for displaying invoice details
                                                echo '<div class="modal fade" id="' . $modalId . '" tabindex="-1" role="dialog" aria-labelledby="' . $modalId . 'Label" aria-hidden="true">';
                                                echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                                                echo '<div class="modal-content">';
                                                echo '<div class="modal-header">';
                                                echo '<h5 class="modal-title" id="' . $modalId . 'Label">Invoice Details</h5>';
                                                echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                                echo '<span aria-hidden="true">&times;</span>';
                                                echo '</button>';
                                                echo '</div>';
                                                echo '<div class="modal-body">';
                                                echo '<p><strong>Invoice ID:</strong> ' . $invId . '</p>';
                                                echo '<p><strong>Invoice Date:</strong> ' . $formattedInvDate . '</p>';
                                                echo '<p><strong>Consultant:</strong> ' . $conFirstName . ' ' . $conLastName . '</p>';
                                                echo '<p><strong>Amount:</strong> $' . $invAmount . '</p>';
                                                // Add more invoice details as needed
                                                
                                                echo '</div>';
                                                echo '<div class="modal-footer">';
                                                echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        } else {
                                            echo '<p>No invoices found.</p>';
                                        }

                                        // Close the database connection
                                        $conn->close();
                                    ?>

                                </div>

                            </div>
                            
                    </div>
                </div>
            </div>

            
            <div class="col-md-4 justify-content-center">

                <?php
                    include 'connect.php';

                    // Fetch the logged-in user's details from the Applicants table
                    $userId = $_SESSION['user_id'];
                    $sql = "SELECT * FROM Applicants WHERE User_ID = $userId";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $applicantId = $row['Appli_ID'];
                        $firstName = $row['Appli_First_Name'];
                        $lastName = $row['Appli_Last_Name'];
                        $address = $row['Appli_Address'];
                        $skypeId = $row['Appli_Skype_ID'];
                        $tpNo = $row['Appli_TP_No'];
                        $dob = $row['Appli_DOB'];
                        $applicantImg = $row['Appli_Img'];
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
                            <img src="<?php echo $applicantImg; ?>" class="img-thumbnail rounded-circle" alt="Applicant Image">
                            <br> <br>
                            <!-- Applicant Details -->
                            <h5 class="card-title"><?php echo $firstName . ' ' . $lastName; ?></h5>
                            <p class="card-text"><strong>Address:</strong> <?php echo $address; ?></p>
                            <p class="card-text"><strong>Skype ID:</strong> <?php echo $skypeId; ?></p>
                            <p class="card-text"><strong>TP Number:</strong> <?php echo $tpNo; ?></p>
                            <p class="card-text"><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
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
<script>
    // JavaScript function to handle the click event on "Edit" button
    function openEditModal(modalId) {
        // Use Bootstrap's JavaScript to show the modal by its ID
        const myModal = new bootstrap.Modal(document.getElementById(modalId));
        myModal.show();
    }
    
</script>

<?php
  include('template_parts/header-footer/footer.php');
?>