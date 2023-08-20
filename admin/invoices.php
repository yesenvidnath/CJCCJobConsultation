<div class="container">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include(__DIR__ . '/../connect.php');


    $action = '';
    $inv_id = '';
    $inv_date = '';
    $user_id = '';
    $ca_apt_id = '';
    $job_id = '';
    $con_id = '';
    $inv_amount = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];
        $inv_id = $_POST['Inv_ID'];
        $inv_date = $_POST['Inv_Date'];
        $user_id = $_POST['User_ID'];
        $ca_apt_id = $_POST['CA_Apt_ID'];
        $job_id = $_POST['Job_ID'];
        $con_id = $_POST['Con_ID'];
        $inv_amount = $_POST['Inv_Amount'];

        switch ($action) {

            case 'insert':
                $sql = "INSERT INTO Invoices (Inv_Date, User_ID, CA_Apt_ID, Job_ID, Con_ID, Inv_Amount) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("siidid", $inv_date, $user_id, $ca_apt_id, $job_id, $con_id, $inv_amount);
                $stmt->execute();
                break;
            
            case 'delete':
                $sql = "DELETE FROM Invoices WHERE Inv_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $inv_id);
                $stmt->execute();
                break;

            case 'search':
                $sql = "SELECT * FROM Invoices WHERE Inv_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $inv_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $inv_id = $row['Inv_ID'];
                    $inv_date = $row['Inv_Date'];
                    $user_id = $row['User_ID'];
                    $ca_apt_id = $row['CA_Apt_ID'];
                    $job_id = $row['Job_ID'];
                    $con_id = $row['Con_ID'];
                    $inv_amount = $row['Inv_Amount'];
                } else {
                    echo "<div class='alert alert-warning'>No invoice found with the given ID</div>";
                }
                break;
            
            case 'update':
                $sql = "UPDATE Invoices SET Inv_Date=?, User_ID=?, CA_Apt_ID=?, Job_ID=?, Con_ID=?, Inv_Amount=? WHERE Inv_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sisiiid", $inv_date, $user_id, $ca_apt_id, $job_id, $con_id, $inv_amount, $inv_id);
                $stmt->execute();
                break;

            case 'generate_pdf':
                require(__DIR__ . '/../fpdf186/fpdf.php'); // Include the FPDF library
            
                // Get the invoice ID from the form data
                $inv_id = $_POST['Inv_ID'];

                // Fetch the invoice details from the database (you may need to modify this query)
                $sql = "SELECT * FROM Invoices WHERE Inv_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $inv_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $invoice = $result->fetch_assoc();

                // Debugging: Print out the invoice data
                print_r($invoice);

                // Fetch job details
                $job_sql = "SELECT * FROM Jobs WHERE Job_ID=?";
                $job_stmt = $conn->prepare($job_sql);
                $job_stmt->bind_param("i", $invoice['Job_ID']);
                $job_stmt->execute();
                $job_result = $job_stmt->get_result();
                $job = $job_result->fetch_assoc();

                // Debugging: Print out the job data
                print_r($job);

                // Fetch applicant details
                $applicant_sql = "SELECT * FROM applicants WHERE User_ID=?";
                $applicant_stmt = $conn->prepare($applicant_sql);
                $applicant_stmt->bind_param("i", $invoice['User_ID']);
                $applicant_stmt->execute();
                $applicant_result = $applicant_stmt->get_result();
                $applicant = $applicant_result->fetch_assoc();

                // Debugging: Print out the applicant data
                print_r($applicant);

                // Fetch consultant details
                $consultant_sql = "SELECT * FROM Consultant WHERE Con_ID=?";
                $consultant_stmt = $conn->prepare($consultant_sql);
                $consultant_stmt->bind_param("i", $invoice['Con_ID']);
                $consultant_stmt->execute();
                $consultant_result = $consultant_stmt->get_result();
                $consultant = $consultant_result->fetch_assoc();

                // Debugging: Print out the consultant data
                print_r($consultant);

                // Create a new PDF instance
                $pdf = new FPDF();
                $pdf->AddPage();

                // Set font for the entire PDF
                $pdf->SetFont('Arial', '', 12);

                // Header
                $pdf->SetFillColor(40, 167, 69); // #28A745 color for header background
                $pdf->SetTextColor(255); // White text color for header
                $pdf->Cell(0, 10, 'Invoice', 0, 1, 'C', 1); // Center-aligned cell with background

                // Set text color to black for the content
                $pdf->SetTextColor(0); // Black text color for content

                // Invoice ID
                $pdf->Ln(30);
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->Cell(0, 10, 'Invoice ID: ' . $inv_id, 0, 1, 'L');

                // Job Title
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Job Title: ' . $job['Job_Title'], 0, 1, 'L');

                // Applicant Name
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Applicant Name: ' . $applicant['Appli_First_Name'] . ' ' . $applicant['Appli_Last_Name'], 0, 1, 'L');

                // Consultant Name
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Consultant Name: ' . $consultant['Con_First_Name'] . ' ' . $consultant['Con_Last_Name'], 0, 1, 'L');

                // Invoice Date
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Invoice Date: ' . $invoice['Inv_Date'], 0, 1, 'L');

                // Invoice Amount
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Invoice Amount: $' . $invoice['Inv_Amount'], 0, 1, 'L');

                $pdf->Ln(30);
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->SetFillColor(40, 167, 69); // #28A745 color for footer background
                $pdf->SetTextColor(255); // White text color for footer
                $pdf->Cell(0, 10, 'CJCC ( Colombo Job Consultation Company ) : info@cjcc.com', 0, 0, 'C', 1); // Center-aligned cell with background

                
                // Output the PDF
                ob_end_clean(); // Clear any previous output
                $pdf->Output('D', 'Invoice.pdf'); // Send to browser for download
                exit(); // Ensure script execution ends
            break;

        }
    }
    ?>

    <div class="row">
        <div class="col-md-4">
            <form id="searchForm" method="POST">
                <div class="form-group">
                    <label for="Inv_ID">Invoice ID:</label>
                    <input type="text" class="form-control" id="Inv_ID" name="Inv_ID" value="<?php echo $inv_id; ?>" required>
                </div>
                <div class="form-group">
                    <label for="Inv_Date">Invoice Date:</label>
                    <input type="datetime-local" class="form-control" id="Inv_Date" name="Inv_Date" value="<?php echo $inv_date; ?>">
                </div>
                <div class="form-group">
                    <label for="User_ID">User ID:</label>
                    <input type="text" class="form-control" id="User_ID" name="User_ID" value="<?php echo $user_id; ?>">
                </div>
                <div class="form-group">
                    <label for="CA_Apt_ID">Consult Appointment ID:</label>
                    <input type="text" class="form-control" id="CA_Apt_ID" name="CA_Apt_ID" value="<?php echo $ca_apt_id; ?>">
                </div>
                <div class="form-group">
                    <label for="Job_ID">Job ID:</label>
                    <input type="text" class="form-control" id="Job_ID" name="Job_ID" value="<?php echo $job_id; ?>">
                </div>
                <div class="form-group">
                    <label for="Con_ID">Consultant ID:</label>
                    <input type="text" class="form-control" id="Con_ID" name="Con_ID" value="<?php echo $con_id; ?>">
                </div>
                <div class="form-group">
                    <label for="Inv_Amount">Invoice Amount:</label>
                    <input type="text" class="form-control" id="Inv_Amount" name="Inv_Amount" value="<?php echo $inv_amount; ?>">
                </div>
                <div class="modal-footer">
                    <div class="container-fluid button-container-custom">
                        <div class="row">
                            <div class="col-6"><input style="width:100%" type="submit" class="btn btn-primary" name="action" value="insert"></div>
                            <div class="col-6"><input style="width:100%" type="submit" class="btn btn-danger" name="action" value="delete"></div>
                        </div>

                        <div class="row">
                            <div class="col-6"><input style="width:100%" type="submit" class="btn btn-info" name="action" value="search"></div>
                            <div class="col-6"><input style="width:100%" type="submit" class="btn btn-success" name="action" value="update"></div>
                        </div>

                        <div class="row">
                            <div class="col-6"><input style="width:100%" type="submit" class="btn btn-primary" name="action" value="generate_pdf"></div>
                            <div class="col-6"><input style="width:100%" type="button" class="btn btn-secondary" onclick="clearForm()" value="clear"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-8">
            <?php
            $result = $conn->query("SELECT * FROM Invoices");
            if ($result->num_rows > 0) {
            ?>
                <div class="table-responsive mt-5">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Invoice Date</th>
                                <th>User ID</th>
                                <th>Consult Appointment ID</th>
                                <th>Job ID</th>
                                <th>Consultant ID</th>
                                <th>Invoice Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row['Inv_ID']; ?></td>
                                    <td><?php echo $row['Inv_Date']; ?></td>
                                    <td><?php echo $row['User_ID']; ?></td>
                                    <td><?php echo $row['CA_Apt_ID']; ?></td>
                                    <td><?php echo $row['Job_ID']; ?></td>
                                    <td><?php echo $row['Con_ID']; ?></td>
                                    <td><?php echo $row['Inv_Amount']; ?></td>
                                </tr>

                            <?php
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            <?php
            } else {
                echo "<div class='alert alert-info mt-5'>No invoices found</div>";
            }
            ?>
        </div>
    </div>

    <script>
        function clearForm() {
            document.getElementById("Inv_ID").value = "";
            document.getElementById("Inv_Date").value = "";
            document.getElementById("User_ID").value = "";
            document.getElementById("CA_Apt_ID").value = "";
            document.getElementById("Job_ID").value = "";
            document.getElementById("Con_ID").value = "";
            document.getElementById("Inv_Amount").value = "";
            

        }
    </script>

    <script>
        function generatePDF(inv_id) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'generate_pdf.php?inv_id=' + inv_id, true);
            xhr.responseType = 'blob';
            xhr.onload = function () {
                const blob = xhr.response;
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'invoice.pdf';
                link.click();
            };
            xhr.send();
        }
    </script>

    <style>
        .button-container-custom .row {
            margin-bottom: 12px;
        }

        .button-container-custom .row .col-6 {
            padding: 0 5px;
        }

        .button-container-custom .row .col-12 {
            padding: 0 5px !important;
        }
    </style>
</div>