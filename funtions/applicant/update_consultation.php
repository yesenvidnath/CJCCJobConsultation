<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $aptId = $_POST["apt_id"];
    $newAptDate = $_POST["apt_date"];

    // Perform additional validation as needed

    // Update the consultation in the database
    include(__DIR__ . '/../../connect.php');

    $stmt = $conn->prepare("UPDATE Consult_Appointment SET CA_Apt_Date = ? WHERE CA_Apt_ID = ?");
    $stmt->bind_param("si", $newAptDate, $aptId);

    if ($stmt->execute()) {
        // Update successful
        echo "Consultation updated successfully.";
        header('Location: ../../dashbord.php');
    } else {
        // Error updating
        echo "Error updating consultation: " . $stmt->error;
    }

    
    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
