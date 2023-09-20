<div class="container">
<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include(__DIR__ . '/../connect.php');
    $action = '';
    $con_id = '';
    $user_id = '';
    $con_img = '';
    $con_first_name = '';
    $con_last_name = '';
    $con_address = '';
    $con_skype_no = '';
    $con_tp_no = '';
    $con_start_time = '';
    $con_end_time = '';
    $con_availability = '';
    $con_description = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];
        $con_id = $_POST['Con_ID'];
        $user_id = $_POST['User_ID'];
        $con_img = $_FILES['Con_Img']['tmp_name'];
        $con_first_name = $_POST['Con_First_Name'];
        $con_last_name = $_POST['Con_Last_Name'];
        $con_address = $_POST['Con_Address'];
        $con_skype_no = $_POST['Con_Skype_No'];
        $con_tp_no = $_POST['Con_TP_No'];
        $con_start_time = $_POST['Con_Avilable_Start_Time'];
        $con_end_time = $_POST['Con_Avilable_End_Time'];
        $con_availability = $_POST['Con_Avilability'];
        $con_description = $_POST['Con_Discription'];

        switch ($action) {
            case 'insert':

                // $target_dir = "assets/con_imgs/";  // Update to match your directory structure
                // $target_file = $target_dir . basename($_FILES["Con_Img"]["name"]);
                
                if (isset($_FILES['Con_Img'])) {
                    $target_file = "assets/con_imgs/" . basename($_FILES["Con_Img"]["name"]);
                
                    if (move_uploaded_file($_FILES["Con_Img"]["tmp_name"], $target_file)) {
                        $con_img = $target_file;
                        echo "<div class='alert alert-success'> The image has been uploaded. </div>";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
                
                $sql = "INSERT INTO Consultant (User_ID, Con_Img, Con_First_Name, Con_Last_Name, Con_Address, Con_Skype_No, Con_TP_No, Con_Avilable_Start_Time, Con_Avilable_End_Time, Con_Avilability, Con_Discription) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issssssssssi", $user_id, $con_img, $con_first_name, $con_last_name, $con_address, $con_skype_no, $con_tp_no, $con_start_time, $con_end_time, $con_availability, $con_description, $con_id);

                $stmt->execute();
                break;

            case 'update':
                
                // // Update target directory and file path
                // $target_dir = "assets/con_imgs/";  // Update to match your directory structure
                // $target_file = $target_dir . basename($_FILES["Con_Img"]["name"]);

                if (isset($_FILES['Con_Img'])) {
                    $target_file = "assets/con_imgs/" . basename($_FILES["Con_Img"]["name"]);
                
                    if (move_uploaded_file($_FILES["Con_Img"]["tmp_name"], $target_file)) {
                        $con_img = $target_file;
                        echo "<div class='alert alert-success'> The image has been uploaded. </div>";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
                
                $sql = "UPDATE Consultant SET User_ID=?, Con_Img=?, Con_First_Name=?, Con_Last_Name=?, Con_Address=?, Con_Skype_No=?, Con_TP_No=?, Con_Avilable_Start_Time=?, Con_Avilable_End_Time=?, Con_Avilability=?, Con_Discription=? WHERE Con_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issssssssssi", $user_id, $con_img, $con_first_name, $con_last_name, $con_address, $con_skype_no, $con_tp_no, $con_start_time, $con_end_time, $con_availability, $con_description, $con_id);

                $stmt->execute();
                break;

            case 'delete':
                $sql = "DELETE FROM Consultant WHERE Con_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $con_id);
                $stmt->execute();
                break;

            case 'search':
                $sql = "SELECT * FROM Consultant WHERE Con_ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $con_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $con_id = $row['Con_ID'];
                    $user_id = $row['User_ID'];
                    $con_img = $row['Con_Img'];
                    $con_first_name = $row['Con_First_Name'];
                    $con_last_name = $row['Con_Last_Name'];
                    $con_address = $row['Con_Address'];
                    $con_skype_no = $row['Con_Skype_No'];
                    $con_tp_no = $row['Con_TP_No'];
                    $con_start_time = $row['Con_Avilable_Start_Time'];
                    $con_end_time = $row['Con_Avilable_End_Time'];
                    $con_availability = $row['Con_Avilability'];
                    $con_description = $row['Con_Discription'];
                } else {
                    echo "<div class='alert alert-warning'>No consultant found with the given ID</div>";
                }
                break;
        }
    }
    ?>

    <div class="row">
        <div class="col-md-4">
            <form id="searchForm" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Con_ID">Consultant ID:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Con_ID" name="Con_ID" value="<?php echo $con_id; ?>" required></div>
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
                    <div class="col-6"><label for="Con_Img">Consultant Image:</label></div>
                    <div class="col-6"><input type="file" class="form-control-file" id="Con_Img" name="Con_Img"></div>
                            <?php if (!empty($con_img)) : ?>
                                <div class="mt-2">
                                    <img id="uploadedImage" src="<?php echo $con_img; ?>" alt="Applicant Image" style="max-width: 150px;">
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Con_First_Name">First Name:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Con_First_Name" name="Con_First_Name" value="<?php echo $con_first_name; ?>"></div>
                    </div>
                </div>
                <div class="form-group">

                    <div class="row">
                        <div class="col-6"><label for="Con_Last_Name">Last Name:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Con_Last_Name" name="Con_Last_Name" value="<?php echo $con_last_name; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Con_Address">Address:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Con_Address" name="Con_Address" value="<?php echo $con_address; ?>"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Con_Skype_No">Skype Number:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Con_Skype_No" name="Con_Skype_No" value="<?php echo $con_skype_no; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Con_TP_No">TP Number:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Con_TP_No" name="Con_TP_No" value="<?php echo $con_tp_no; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Con_Avilable_Start_Time">Available Start Time:</label></div>
                        <div class="col-6"><input type="time" class="form-control" id="Con_Avilable_Start_Time" name="Con_Avilable_Start_Time" value="<?php echo $con_start_time; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Con_Avilable_End_Time">Available End Time:</label></div>
                        <div class="col-6"><input type="time" class="form-control" id="Con_Avilable_End_Time" name="Con_Avilable_End_Time" value="<?php echo $con_end_time; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Con_Avilability">Availability:</label></div>
                        <div class="col-6"><input type="text" class="form-control" id="Con_Avilability" name="Con_Avilability" value="<?php echo $con_availability; ?>"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><label for="Con_Discription">Description:</label></div>
                        <div class="col-6"> <textarea class="form-control" id="Con_Discription" name="Con_Discription"><?php echo $con_description; ?></textarea></div>
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
            $result = $conn->query("SELECT * FROM Consultant");
            if ($result->num_rows > 0) {
            ?>
                <div class="table-responsive mt-5">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Consultant ID</th>
                                <th>User ID</th>
                                <th>Image</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>Skype Number</th>
                                <th>TP Number</th>
                                <th>Available Start Time</th>
                                <th>Available End Time</th>
                                <th>Availability</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row['Con_ID']; ?></td>
                                    <td><?php echo $row['User_ID']; ?></td>
                                    <td>
                                        <img src="<?php echo $row['Con_Img']; ?>" alt="Consultant Image" width="50">
                                    </td>
                                    <td><?php echo $row['Con_First_Name']; ?></td>
                                    <td><?php echo $row['Con_Last_Name']; ?></td>
                                    <td><?php echo $row['Con_Address']; ?></td>
                                    <td><?php echo $row['Con_Skype_No']; ?></td>
                                    <td><?php echo $row['Con_TP_No']; ?></td>
                                    <td><?php echo $row['Con_Avilable_Start_Time']; ?></td>
                                    <td><?php echo $row['Con_Avilable_End_Time']; ?></td>
                                    <td><?php echo $row['Con_Avilability']; ?></td>
                                    <td><?php echo $row['Con_Discription']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
                echo "<div class='alert alert-info mt-5'>No consultants found</div>";
            }
            ?>
        </div>
    </div>

    <script>
        function clearForm() {
            document.getElementById("Con_ID").value = "";
            document.getElementById("User_ID").value = "";
            document.getElementById("Con_First_Name").value = "";
            document.getElementById("Con_Last_Name").value = "";
            document.getElementById("Con_Address").value = "";
            document.getElementById("Con_Skype_No").value = "";
            document.getElementById("Con_TP_No").value = "";
            document.getElementById("Con_Avilable_Start_Time").value = "";
            document.getElementById("Con_Avilable_End_Time").value = "";
            document.getElementById("Con_Avilability").value = "";
            document.getElementById("Con_Discription").value = "";

            // Clear the selected image and remove the preview
            var oldInput = document.getElementById("Con_Img");
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
