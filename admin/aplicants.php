<div class="container">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include(__DIR__ . '/../connect.php');
    $action = '';
    $appli_id = '';
    $user_id = '';
    $appli_img = '';
    $appli_first_name = '';
    $appli_last_name = '';
    $appli_address = '';
    $appli_skype_id = '';
    $appli_tp_no = '';
    $appli_dob = '';
    $appli_resume = '';
    


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];
        $appli_id = $_POST['Appli_ID'];
        $user_id = $_POST['User_ID'];
        $appli_img = $_POST['Appli_Img'];
        $appli_first_name = $_POST['Appli_First_Name'];
        $appli_last_name = $_POST['Appli_Last_Name'];
        $appli_address = $_POST['Appli_Address'];
        $appli_skype_id = $_POST['Appli_Skype_ID'];
        $appli_tp_no = $_POST['Appli_TP_No'];
        $appli_dob = $_POST['Appli_DOB'];
        $appli_resume = $_POST['Appli_Resume'];

        switch ($action) {
            case 'insert':
                $sql = "INSERT INTO Applicants (User_ID, Appli_Img, Appli_First_Name, Appli_Last_Name, Appli_Address, Appli_Skype_ID, Appli_TP_No, Appli_DOB, Appli_Resume) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issssssss", $user_id, $appli_img, $appli_first_name, $appli_last_name, $appli_address, $appli_skype_id, $appli_tp_no, $appli_dob, $appli_resume);
                $stmt->execute();
                break;

            case 'delete':
                $sql = "DELETE FROM Applicants WHERE Appli_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $appli_id);
                $stmt->execute();
                break;

            case 'search':
                $sql = "SELECT * FROM Applicants WHERE Appli_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $appli_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $appli_id = $row['Appli_ID'];
                    $user_id = $row['User_ID'];
                    $appli_img = $row['Appli_Img'];
                    $appli_first_name = $row['Appli_First_Name'];
                    $appli_last_name = $row['Appli_Last_Name'];
                    $appli_address = $row['Appli_Address'];
                    $appli_skype_id = $row['Appli_Skype_ID'];
                    $appli_tp_no = $row['Appli_TP_No'];
                    $appli_dob = $row['Appli_DOB'];
                    $appli_resume = $row['Appli_Resume'];
                } else {
                    echo "<div class='alert alert-warning'>No applicant found with the given ID</div>";
                }
                break;
            case 'update':
                $sql = "UPDATE Applicants SET User_ID=?, Appli_Img=?, Appli_First_Name=?, Appli_Last_Name=?, Appli_Address=?, Appli_Skype_ID=?, Appli_TP_No=?, Appli_DOB=?, Appli_Resume=? WHERE Appli_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issssssssi", $user_id, $appli_img, $appli_first_name, $appli_last_name, $appli_address, $appli_skype_id, $appli_tp_no, $appli_dob, $appli_resume, $appli_id);
                $stmt->execute();
                break;    
            
        }
    }
    ?>

    <div class="row">
        <div class="col-md-4">
            <form id="searchForm" method="POST">
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Appli_ID">Applicant ID:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Appli_ID" name="Appli_ID" value="<?php echo $appli_id; ?>" required></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="User_ID">User ID:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="User_ID" name="User_ID" value="<?php echo $user_id; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"> <label for="Appli_Img">Applicant Image:</label></div>
                        <div class="col-6">
                            <input type="file" class="form-control-file" id="Appli_Img" name="Appli_Img">
                            <?php if (!empty($appli_img)) : ?>
                                <div class="mt-2">
                                    <img id="uploadedImage" src="<?php echo $appli_img; ?>" alt="Applicant Image" style="max-width: 150px;">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Appli_First_Name">First Name:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Appli_First_Name" name="Appli_First_Name" value="<?php echo $appli_first_name; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Appli_Last_Name">Last Name:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Appli_Last_Name" name="Appli_Last_Name" value="<?php echo $appli_last_name; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Appli_Address">Address:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Appli_Address" name="Appli_Address" value="<?php echo $appli_address; ?>"></div>
                    </div>
                    
                   
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Appli_Skype_ID">Skype ID:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Appli_Skype_ID" name="Appli_Skype_ID" value="<?php echo $appli_skype_id; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Appli_TP_No">TP Number:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Appli_TP_No" name="Appli_TP_No" value="<?php echo $appli_tp_no; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Appli_DOB">Date of Birth:</label></div>
                        <div class="col-6"><input type="date" class="form-control" id="Appli_DOB" name="Appli_DOB" value="<?php echo $appli_dob; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"> <label for="Appli_Resume">Resume:</label></div>
                        <div class="col-6"> <input type="text" class="form-control" id="Appli_Resume" name="Appli_Resume" value="<?php echo $appli_resume; ?>"></div>
                    </div>
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
            $result = $conn->query("SELECT * FROM Applicants");
            if ($result->num_rows > 0) {
            ?>
                <div class="table-responsive mt-5">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Applicant ID</th>
                                <th>User ID</th>
                                <th>Image</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>Skype ID</th>
                                <th>TP Number</th>
                                <th>Date of Birth</th>
                                <th>Resume</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row['Appli_ID']; ?></td>
                                    <td><?php echo $row['User_ID']; ?></td>
                                    <td>
                                        <img src="<?php echo $row['Appli_Img']; ?>" alt="Applicents Image" width="50">
                                    </td>
                                    <td><?php echo $row['Appli_First_Name']; ?></td>
                                    <td><?php echo $row['Appli_Last_Name']; ?></td>
                                    <td><?php echo $row['Appli_Address']; ?></td>
                                    <td><?php echo $row['Appli_Skype_ID']; ?></td>
                                    <td><?php echo $row['Appli_TP_No']; ?></td>
                                    <td><?php echo $row['Appli_DOB']; ?></td>
                                    <td><?php echo $row['Appli_Resume']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
                echo "<div class='alert alert-info mt-5'>No applicants found</div>";
            }
            ?>
        </div>
    </div>

    <script>
        function clearForm() {
            document.getElementById("Appli_ID").value = "";
            document.getElementById("User_ID").value = "";
            document.getElementById("Appli_First_Name").value = "";
            document.getElementById("Appli_Last_Name").value = "";
            document.getElementById("Appli_Address").value = "";
            document.getElementById("Appli_Skype_ID").value = "";
            document.getElementById("Appli_TP_No").value = "";
            document.getElementById("Appli_DOB").value = "";
            document.getElementById("Appli_Resume").value = "";

            // Clear the selected image and remove the preview
            var oldInput = document.getElementById("Appli_Img");
            var newInput = document.createElement("input");
            newInput.type = "file";
            newInput.className = oldInput.className;
            newInput.id = oldInput.id;
            newInput.name = oldInput.name;
            oldInput.parentNode.replaceChild(newInput, oldInput);

            var uploadedImage = document.getElementById("uploadedImage");
            if (uploadedImage) {
                uploadedImage.parentNode.removeChild(uploadedImage);
            }
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
