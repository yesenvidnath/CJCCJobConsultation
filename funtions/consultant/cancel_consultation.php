<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $aptId = $_POST["apt_id"];
    
    // Perform additional validation as needed
    
    include(__DIR__ . '/../../connect.php');

    // Update the CA_status to "Cancelled"
    $status = "Cancel";
    
    $stmt = $conn->prepare("UPDATE Consult_Appointment SET CA_status = ? WHERE CA_Apt_ID = ?");
    $stmt->bind_param("si", $status, $aptId);

    if ($stmt->execute()) {
        // Update successful
        echo "Consultation with ID $aptId has been successfully cancelled.";
        header('Location: ../../Consultant_dashbord.php');
    } else {
        // Error updating
        echo "Error updating consultation: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
