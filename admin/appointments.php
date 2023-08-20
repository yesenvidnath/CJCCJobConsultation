<div class="container">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include(__DIR__ . '/../connect.php');
    $action = '';
    $apt_id = '';
    $apt_date = '';
    $job_id = '';
    $con_id = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];
        $apt_id = $_POST['CA_Apt_ID'];
        $apt_date = $_POST['CA_Apt_Date'];
        $job_id = $_POST['Job_ID'];
        $con_id = $_POST['Con_ID'];
        switch ($action) {
            case 'insert':
                $sql = "INSERT INTO Consult_Appointment (CA_Apt_Date, Job_ID, Con_ID) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sii", $apt_date, $job_id, $con_id);
                $stmt->execute();
                break;
            case 'delete':
                $sql = "DELETE FROM Consult_Appointment WHERE CA_Apt_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $apt_id);
                $stmt->execute();
                break;
            case 'search':
                $sql = "SELECT * FROM Consult_Appointment WHERE CA_Apt_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $apt_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $apt_id = $row['CA_Apt_ID'];
                    $apt_date = $row['CA_Apt_Date'];
                    $job_id = $row['Job_ID'];
                    $con_id = $row['Con_ID'];
                } else {
                    echo "<div class='alert alert-warning'>No appointment found with the given ID</div>";
                }
                break;
            case 'update':
                $sql = "UPDATE Consult_Appointment SET CA_Apt_Date=?, Job_ID=?, Con_ID=? WHERE CA_Apt_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("siii", $apt_date, $job_id, $con_id, $apt_id);
                $stmt->execute();
                break;
        }
    }
    ?>

    <div class="row">
        <div class="col-md-4">
            <form id="searchForm" method="POST">
                <div class="form-group">
                    <label for="CA_Apt_ID">Appointment ID:</label>
                    <input type="text" class="form-control" id="CA_Apt_ID" name="CA_Apt_ID" value="<?php echo $apt_id; ?>" required>
                </div>
                <div class="form-group">
                    <label for="CA_Apt_Date">Appointment Date:</label>
                    <input type="datetime-local" class="form-control" id="CA_Apt_Date" name="CA_Apt_Date" value="<?php echo $apt_date; ?>" required>
                </div>
                <div class="form-group">
                    <label for="Job_ID">Job ID:</label>
                    <input type="text" class="form-control" id="Job_ID" name="Job_ID" value="<?php echo $job_id; ?>">
                </div>
                <div class="form-group">
                    <label for="Con_ID">Consultant ID:</label>
                    <input type="text" class="form-control" id="Con_ID" name="Con_ID" value="<?php echo $con_id; ?>">
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
                            <div class="col-12"><input style="width:100%" type="button" class="btn btn-secondary" onclick="clearForm()" value="clear"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-8">
            <?php
            $result = $conn->query("SELECT * FROM Consult_Appointment");
            if ($result->num_rows > 0) {
            ?>
                <div class="table-responsive mt-5">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Appointment Date</th>
                                <th>Job ID</th>
                                <th>Consultant ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row['CA_Apt_ID']; ?></td>
                                    <td><?php echo $row['CA_Apt_Date']; ?></td>
                                    <td><?php echo $row['Job_ID']; ?></td>
                                    <td><?php echo $row['Con_ID']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
                echo "<div class='alert alert-info mt-5'>No appointments found</div>";
            }
            ?>
        </div>
    </div>

    <script>
        function clearForm() {
            document.getElementById("CA_Apt_ID").value = "";
            document.getElementById("CA_Apt_Date").value = "";
            document.getElementById("Job_ID").value = "";
            document.getElementById("Con_ID").value = "";
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
