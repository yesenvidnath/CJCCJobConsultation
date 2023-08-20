<?php
  include('template_parts/header-footer/header.php');
  //Connnection methode
  include('connect.php');
?>

<section class="con-dashbord-section">

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
                                    <a class="nav-link active" data-toggle="tab" href="#Settings">Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Consultations">Consultations</a>
                                </li>
                                <!-- Add more tabs as needed -->
                            </ul>
                        </div>

                            <!-- Right Content Area -->
                            <div class="tab-content" id="dashboardTabContent">
                                <!-- Profile Tab -->

                                <!-- Applications Tab -->
                                <div class="tab-pane fade show active" id="Settings">
                                    <h3>Consultant Settings</h3>

                                    <?php
                                        // Fetch the logged-in user's details from the Consultant table
                                        $userId = $_SESSION['user_id'];
                                        $sql = "SELECT * FROM Consultant WHERE User_ID = $userId";
                                        $result = $conn->query($sql);

                                        if ($result && $result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $ConID = $row['Con_ID'];
                                            $ConImg = $row['Con_Img'];
                                            $ConFirstName = $row['Con_First_Name'];
                                            $ConLastName = $row['Con_Last_Name'];
                                            $ConAddress = $row['Con_Address'];
                                            $ConSkype_No = $row['Con_Skype_No'];
                                            $ConTPNo = $row['Con_TP_No'];
                                            $ConAvilableStartTime = $row['Con_Avilable_Start_Time'];
                                            $ConAvilable_EndTime = $row['Con_Avilable_End_Time'];
                                            $ConAvilability = $row['Con_Avilability'];
                                            $ConDiscription = $row['Con_Discription'];
                                        } else {
                                            // Handle the case when the user's details are not found
                                            echo "User details not found.";
                                        }
                                    ?>
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $ConFirstName; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $ConLastName; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $ConAddress; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="skypeId">Skype ID</label>
                                            <input type="text" class="form-control" id="skypeId" name="skypeId" value="<?php echo $ConSkype_No; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tpNo">TP Number</label>
                                            <input type="tel" class="form-control" id="tpNo" name="tpNo" value="<?php echo $ConTPNo; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="availableStartTime">Available Start Time</label>
                                            <input type="time" class="form-control" id="availableStartTime" name="availableStartTime" value="<?php echo $ConAvilableStartTime; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="availableEndTime">Available End Time</label>
                                            <input type="time" class="form-control" id="availableEndTime" name="availableEndTime" value="<?php echo $ConAvilable_EndTime; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="availability">Availability</label>
                                            <select class="form-control" id="availability" name="availability" required>
                                                <option value="Available" <?php if ($ConAvilability === 'Available') echo 'selected'; ?>>Available</option>
                                                <option value="Not Available" <?php if ($ConAvilability === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $ConDiscription; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="consultantImg">Consultant Image</label>
                                            <input type="file" class="form-control-file" id="consultantImg" name="consultantImg">
                                        </div>

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
                                        $availableStartTime = $_POST["availableStartTime"];
                                        $availableEndTime = $_POST["availableEndTime"];
                                        $availability = $_POST["availability"];
                                        $description = $_POST["description"];

                                        // Process the uploaded image
                                        if (!empty($_FILES["consultantImg"]["name"])) {
                                            $targetDir = "uploads/";
                                            $targetFile = $targetDir . basename($_FILES["consultantImg"]["name"]);
                                            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                                            $newImageName = "consultant_" . $ConID . "." . $imageFileType;

                                            if (move_uploaded_file($_FILES["consultantImg"]["tmp_name"], $targetDir . $newImageName)) {
                                                $ConImg = $newImageName;
                                            } else {
                                                echo "Error uploading image.";
                                            }
                                        }

                                        // Update the consultant's details in the database
                                        $sql = "UPDATE Consultant 
                                                SET Con_First_Name = '$firstName', 
                                                    Con_Last_Name = '$lastName',
                                                    Con_Address = '$address',
                                                    Con_Skype_No = '$skypeId',
                                                    Con_TP_No = '$tpNo',
                                                    Con_Avilable_Start_Time = '$availableStartTime',
                                                    Con_Avilable_End_Time = '$availableEndTime',
                                                    Con_Avilability = '$availability',
                                                    Con_Discription = '$description',
                                                    Con_Img = '$ConImg'
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
                                <div class="tab-pane fade" id="Consultations">

                                    <br><br>
                                    
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <?php
                                            // Fetch the consultations allocated to the consultant from the Consult_Appointment table
                                            include 'connect.php';
                                            $consultantId = $_SESSION['user_id']; // Assuming the logged-in user is a consultant
                                            $sql = "SELECT CA.CA_Apt_ID, CA.CA_Apt_Date, CA.CA_status, J.Job_Title, A.Appli_First_Name, A.Appli_Last_Name
                                                    FROM Consult_Appointment AS CA
                                                    JOIN Jobs AS J ON CA.Job_ID = J.Job_ID
                                                    JOIN applicants AS A ON CA.Appli_ID = A.Appli_ID
                                                    WHERE CA.Con_ID  = $consultantId";
                                            $result = $conn->query($sql);

                                            if ($result && $result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $aptId = $row['CA_Apt_ID'];
                                                    $aptDate = $row['CA_Apt_Date'];
                                                    $CA_status = $row['CA_status'];
                                                    $jobTitle = $row['Job_Title'];
                                                    $appliFirstName = $row['Appli_First_Name'];
                                                    $appliLastName = $row['Appli_Last_Name'];

                                                    // Format the appointment date
                                                    $formattedAptDate = date("M d, Y - h:i A", strtotime($aptDate));

                                                    // Generate a unique ID for the modal using consultant ID and appointment ID
                                                    $modalId = 'editModal' . $consultantId . '_' . $aptId . '_' . uniqid();

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

                                                    echo '<p class="card-text">Applicant: ' . $appliFirstName . ' ' . $appliLastName . '</p>';
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
                                                    echo '<form action="./funtions/consultant/update_consultation.php" method="POST" class="mb-3">';
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
                                                            echo '<form action="./funtions/consultant/cancel_consultation.php" style="width:100%; margin:0;" method="POST" class="d-inline-block">
                                                            <input type="hidden" name="apt_id" value="' . $aptId . '">
                                                            <button style="width:100%; margin:0;" type="submit" class="btn btn-secondary" onclick="return confirm(\'Are you sure you want to Cancel this consultation?\')"><i class="fas fa-trash"></i> Cancel Now</button>
                                                            </form>';
                                                        } else {
                                                            echo '<form action="./funtions/consultant/active_consultation.php" style="width:100%; margin:0;" method="POST" class="d-inline-block">
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
                            </div>
                    </div>
                </div>
            </div>

            
            <div class="col-md-4 justify-content-center">

                <?php
                    include 'connect.php';

                    // Fetch the logged-in user's details from the Consultant table
                    $userId = $_SESSION['user_id'];
                    $sql = "SELECT * FROM Consultant WHERE User_ID = $userId";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $ConID = $row['Con_ID'];
                        $ConImg = $row['Con_Img'];
                        $ConFirstName = $row['Con_First_Name'];
                        $ConLastName = $row['Con_Last_Name'];
                        $ConAddress = $row['Con_Address'];
                        $ConSkype_No = $row['Con_Skype_No'];
                        $ConTPNo = $row['Con_TP_No'];
                        $ConAvilableStartTime = $row['Con_Avilable_Start_Time'];
                        $ConAvilable_EndTime = $row['Con_Avilable_End_Time'];
                        $ConAvilability = $row['Con_Avilability'];
                        $ConDiscription = $row['Con_Discription'];
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
                            <img src="<?php echo $ConImg; ?>" class="img-thumbnail rounded-circle" alt="Consultant Image">
                            <br><br>
                            <h5 class="card-title"><?php echo $ConFirstName . ' ' . $ConLastName; ?></h5>
                            <p class="card-text"><strong>Address:</strong> <?php echo $ConAddress; ?></p>
                            <p class="card-text"><strong>Skype ID:</strong> <?php echo $ConSkype_No; ?></p>
                            <p class="card-text"><strong>TP Number:</strong> <?php echo $ConTPNo; ?></p>
                            <p class="card-text"><strong>Availability:</strong> <?php echo $ConAvilability; ?></p>
                            <p class="card-text"><strong>Start Time:</strong> <?php echo $ConAvilableStartTime; ?></p>
                            <p class="card-text"><strong>End Time:</strong> <?php echo $ConAvilable_EndTime; ?></p>
                            <p class="card-text"><strong>Description:</strong> <?php echo $ConDiscription; ?></p>
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