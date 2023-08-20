<?php
include('template_parts/header-footer/header.php');
include('connect.php');

?>

<section class="Job-apply-section">
    <!-- Your apply.php page content goes here -->
    <div class="container">
        <div class="row">
            <div class="col-md-5">

                <?php
                // Check if the job_id query parameter is present in the URL
                if (isset($_GET['job_id'])) {
                    // Get the job ID from the query parameter
                    $jobId = $_GET['job_id'];

                    // Fetch the details of the selected job using the job ID
                    $sql = "SELECT * FROM Jobs WHERE Job_ID = $jobId";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Job found, retrieve job details
                        $row = $result->fetch_assoc();
                        $jobTitle = $row['Job_Title'];
                        $jobCountry = $row['Job_country'];
                        $jobDescription = $row['Job_Disc'];
                        $jobImage = $row['Job_Image'];

                        // Now you have all the job details, you can display them on the apply.php page as needed
                        // For example:
                ?>
                    <div class="card card-main">
                        <h2><?php echo $jobTitle; ?></h2>
                        <img src="<?php echo $jobImage; ?>" alt="Job Image" class="img-fluid">
                        <br><br>
                        <p class="label-job">From: <?php echo $jobCountry; ?></p>
                        <p class="job-desc"><?php echo $jobDescription; ?></p>
                    </div>
                <?php
                    } else {
                        // Job not found or invalid job ID
                        echo "<p>Job not found or invalid job ID.</p>";
                    }

                    // Close the database connection
                    $conn->close();
                } else {
                    // If the job_id query parameter is not present in the URL, display an error or redirect to the main page
                    echo "<p>Invalid request. Please select a job to apply.</p>";
                }
                ?>

            </div>

            <div class="col-md-7">
                <h2>Schedule Consultant Appointment</h2>
                <br>
                <center>
                <img src="assets/other/free-consultation-for-busseness-owners.svg" alt="" width="40%">
                </center>
                <br>
                
                <form id="appointmentForm" >
                    <!-- Hidden input to pass logged-in user's ID -->
                    <input type="hidden" name="Job_ID" value="<?php echo $jobId; ?>">

                    <input type="hidden" name="Appli_ID" value="<?php 
                    
                        $user_id = $_SESSION['user_id'];

                        include 'connect.php';

                        $sql = "SELECT A.Appli_ID
                        FROM Applicants AS A
                        JOIN Users AS U ON A.User_ID = U.User_ID
                        WHERE U.User_ID = $user_id";

                        $result = $conn->query($sql);
                    
                        if ($result->num_rows > 0) {
                            // Loop through the results and fetch the "Appli_ID"
                            while ($row = $result->fetch_assoc()) {
                                $appliID = $row["Appli_ID"];
                                // Do something with the Appli_ID, e.g., store it in an array, display it, etc.
                                echo $appliID;
                            }
                        } else {
                            echo "No applicants found.";
                        }
                       
                    ?>">

                    <!-- Consultant -->
                    <div class="form-group">
                        <!-- ... Your other form elements ... -->
                        <div class="custom-dropdown" id="jobDropdown">
                            <button class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select a Consultant</button>
                            <div class="dropdown-menu" aria-labelledby="jobDropdown">
                                <?php
                                include 'connect.php';
                                // Fetch available consultants from the database
                                $sql = "SELECT Con_ID, Con_First_Name, Con_Img FROM Consultant WHERE Con_Status = 'Available'";
                                $result = $conn->query($sql);

                                // Display the available consultants in the custom dropdown
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $con_id = $row["Con_ID"];
                                        $con_first_name = $row["Con_First_Name"];
                                        $con_img = $row["Con_Img"];

                                        // Create the dropdown item with consultant details and ID attribute
                                        echo "<div class='dropdown-item' data-value='$con_id' id='con_$con_id'>";
                                        echo "<img src='$con_img' alt='Consultant Image' style='width: 50px; height: 50px; border-radius: 50%;'>";
                                        echo "<span>$con_first_name</span>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<div class='dropdown-item'>No available consultants.</div>";
                                }

                                
                                ?>
                                
                            </div>
                            
                            <input type="hidden" id="job_id" name="job_id" required>
                        </div>
                    </div>

                        <input type="hidden" name="Con_ID" id="con_id" required>

                    <!-- Date and Time selection -->
                    <div class="form-group">
                        <label for="appointment_date">Select Appointment Date</label>
                        <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" required>
                    </div>
                    
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-success">Schedule Appointment</button>
                </form>

            </div>
        </div>
    </div>
</section>

<!-- Add the Bootstrap modal to your apply.php file -->
<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Appointment Scheduled Successfully</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- The appointment details will be filled here using JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success " data-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>

<!-- Add the updated JavaScript code to your apply.php file -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("appointmentForm");

        form.addEventListener("submit", function(event) {
            event.preventDefault();

            const formData = new FormData(form);

            fetch("schedule_appointment.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Show the modal with the appointment details if the response is not empty
                if (data.trim() !== "") {
                    const consultantName = data;
                    const appointmentDate = formData.get("appointment_date");

                    // Show the modal with the appointment details
                    const modalTitle = document.getElementById("appointmentModalLabel");
                    const modalBody = document.getElementById("modalBody");

                    modalTitle.textContent = "Appointment Scheduled Successfully";
                    modalBody.innerHTML = `<p><strong>Consultant Name:</strong> ${consultantName}</p>
                                           <p><strong>Date and Time:</strong> ${appointmentDate}</p>`;

                    // Show the modal
                    $("#appointmentModal").modal("show");

                    // After a short delay, redirect back to the home page
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 12000); // Redirect after 3 seconds (adjust the delay as needed)
                } else {
                    // If the response is empty, display an error message or handle it as needed
                    console.error("Error scheduling appointment: Consultant name not detected in the response.");
                }
            })
            .catch(error => console.error("Error scheduling appointment:", error));
        });
    });
</script>


<?php
include('template_parts/header-footer/footer.php');
?>
