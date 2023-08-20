<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $jobId = $_POST["Job_ID"];
    $appliId = $_POST["Appli_ID"];
    $conId = $_POST["Con_ID"]; // Assuming you added an ID attribute to the dropdown items

    $appointmentDate = $_POST["appointment_date"];

    // Additional validation can be performed here if needed

    // Check if the Appli_ID exists in the Applicants table
    include 'connect.php';
    $stmt = $conn->prepare("SELECT Appli_ID FROM Applicants WHERE Appli_ID = ?");
    $stmt->bind_param("i", $appliId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "Error scheduling appointment: Invalid applicant ID.";
        exit();
    }

    // Insert the data into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO Consult_Appointment (CA_Apt_Date, CA_status, Job_ID, Con_ID, Appli_ID) VALUES (?, 'Active', ?, ?, ?)");
    $stmt->bind_param("siii", $appointmentDate, $jobId, $conId, $appliId);

    $consultantName = ""; // Variable to store the consultant name

    if ($stmt->execute()) {
        // Get the consultant's name for the response
        $sql = "SELECT Con_First_Name FROM Consultant WHERE Con_ID = ?";
        $stmtConsultant = $conn->prepare($sql);
        $stmtConsultant->bind_param("i", $conId);
        $stmtConsultant->execute();
        $resultConsultant = $stmtConsultant->get_result();
        if ($resultConsultant && $resultConsultant->num_rows > 0) {
            $rowConsultant = $resultConsultant->fetch_assoc();
            $consultantName = $rowConsultant["Con_First_Name"];
        }
        
        // Get the logged-in user's ID from the session
        $user_id = $_SESSION['user_id'];

        // Capture the inserted ID before closing the statement
        $insertedId = $stmt->insert_id;

        // Insert an invoice record
        $inv_date = date('Y-m-d H:i:s'); // Current date and time
        $inv_amount = 100.00; // Replace with the actual invoice amount
        $sqlInvoice = "INSERT INTO Invoices (Inv_Date, User_ID, CA_Apt_ID, Job_ID, Con_ID, Inv_Amount)
                      VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInvoice = $conn->prepare($sqlInvoice);
        $stmtInvoice->bind_param("siidid", $inv_date, $user_id, $insertedId, $jobId, $conId, $inv_amount);
        $stmtInvoice->execute();
    } else {
        echo "Error scheduling appointment: " . $stmt->error;
    }

    // Close the statements and database connection
    $stmt->close();
    $stmtConsultant->close();
    $stmtInvoice->close();
    $conn->close();

    // Return the consultant name as part of the response
    echo $consultantName;
}
?>
