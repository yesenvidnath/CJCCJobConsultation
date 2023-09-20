<div class="container">
    <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        include(__DIR__ . '/../connect.php');
        $action = '';
        $job_id = '';
        $job_title = '';
        $job_country = '';
        $job_disc = '';
        $job_end_date = '';
        $job_image = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $action = $_POST['action'];
            $job_id = $_POST['Job_ID'];
            $job_title = $_POST['Job_Title'];
            $job_country = $_POST['Job_country'];
            $job_disc = $_POST['Job_Disc'];
            $job_end_date = $_POST['Job_End_Date'];

            switch ($action) {

                case 'insert':
                    // Update target directory and file path
                    $target_dir = "assets/job_imgs/";  // Update to match your directory structure
                    $target_file = $target_dir . basename($_FILES["Job_image"]["name"]);

                    if (move_uploaded_file($_FILES["Job_image"]["tmp_name"], $target_file)) {
                        $job_image = $target_file;
                        echo "<div class='alert alert-success'> The file image has been uploaded. </div>";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }

                    // Insert data into the database
                    $sql = "INSERT INTO jobs (Job_Title, Job_country, Job_Disc, Job_End_Date, Job_Image) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $job_title, $job_country, $job_disc, $job_end_date, $job_image);
                    $stmt->execute();
                    break;

                case 'update':

                    // Update target directory and file path
                    $target_dir = "assets/job_imgs/";  // Update to match your directory structure
                    $target_file = $target_dir . basename($_FILES["Job_image"]["name"]);

                    if (move_uploaded_file($_FILES["Job_image"]["tmp_name"], $target_file)) {
                        $job_image = $target_file;
                        echo "The file ". basename( $_FILES["Job_image"]["name"]). " has been uploaded.";
                    } else {
                        echo "<div class='alert alert-success'> The file image has been uploaded. </div>";
                    }

                    // Update data in the database
                    $sql = "UPDATE jobs SET Job_Title=?, Job_country=?, Job_Disc=?, Job_End_Date=?, Job_Image=? WHERE Job_ID=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssi", $job_title, $job_country, $job_disc, $job_end_date, $job_image, $job_id);
                    $stmt->execute();
                    break;

                case 'delete':
                    $sql = "DELETE FROM jobs WHERE Job_ID=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $job_id);
                    $stmt->execute();
                    break;

                case 'search':
                    $sql = "SELECT * FROM jobs WHERE Job_ID=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $job_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $job_id = $row['Job_ID'];
                        $job_title = $row['Job_Title'];
                        $job_country = $row['Job_country'];
                        $job_disc = $row['Job_Disc'];
                        $job_end_date = $row['Job_End_Date'];
                        $job_image = $row['Job_Image'];
                    } else {
                        echo "<div class='alert alert-warning'>No job found with the given ID</div>";
                    }
                    break;
            }
        }
    ?>

    <div class="row">

        <div class="col-md-4">

            <form id="searchForm" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="Job_ID">Job ID:</label>
                    <input type="text" class="form-control" id="Job_ID" name="Job_ID" value="<?php echo $job_id; ?>" required>
                </div>
                <div class="form-group">
                    <label for="Job_Title">Job Title:</label>
                    <input type="text" class="form-control" id="Job_Title" name="Job_Title" value="<?php echo $job_title; ?>">
                </div>
                <div class="form-group">
                    <label for="Job_country">Job Country:</label>
                    <input type="text" class="form-control" id="Job_country" name="Job_country" value="<?php echo $job_country; ?>">
                </div>
                <div class="form-group">
                    <label for="Job_Disc">Job Description:</label>
                    <input type="text" class="form-control" id="Job_Disc" name="Job_Disc" value="<?php echo $job_disc; ?>">
                </div>
                <div class="form-group">
                    <label for="Job_End_Date">Job End Date:</label>
                    <input type="date" class="form-control" id="Job_End_Date" name="Job_End_Date" value="<?php echo $job_end_date; ?>">
                </div>
                <div class="form-group">
                    <label for="Job_Image">Job Image:</label>
                    <input type="file" class="form-control-file" id="Job_Image" name="Job_image">
                    <?php if (!empty($job_image)) : ?>
                        <div class="mt-2">
                            <img id="uploadedImage" src="<?php echo $job_image; ?>" alt="Job_Image Image" style="max-width: 150px;">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid button-container-custom">
                        <div class="row">
                            <div class="col-6"><input style="width:100%" type="submit" class="btn btn-primary" name="action" value="insert"></div>
                            <div class="col-6"><input style="width:100%" type="submit" class="btn btn-success" name="action" value="update"></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><input style="width:100%" type="submit" class="btn btn-danger" name="action" value="delete"></div>
                            <div class="col-6"><input style="width:100%" type="submit" class="btn btn-info" name="action" value="search"></div>
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
            $result = $conn->query("SELECT * FROM jobs");
            if ($result->num_rows > 0) {
            ?>
                <div class="table-responsive mt-5">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Job ID</th>
                                <th>Job Title</th>
                                <th>Job Country</th>
                                <th>Job Description</th>
                                <th>Job End Date</th>
                                <th>Job Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row['Job_ID']; ?></td>
                                    <td><?php echo $row['Job_Title']; ?></td>
                                    <td><?php echo $row['Job_country']; ?></td>
                                    <td><?php echo $row['Job_Disc']; ?></td>
                                    <td><?php echo $row['Job_End_Date']; ?></td>
                                    <td>
                                        <img src="<?php echo $row['Job_Image']; ?>" alt="Applicents Image" width="50">
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
                echo "<div class='alert alert-info mt-5'>No jobs found</div>";
            }
            ?>
        </div>
    </div>

    <script>
        function clearForm() {
            document.getElementById("Job_ID").value = "";
            document.getElementById("Job_Title").value = "";
            document.getElementById("Job_country").value = "";
            document.getElementById("Job_Disc").value = "";
            document.getElementById("Job_End_Date").value = "";
            
            // Clear the selected image and remove the preview
            var oldInput = document.getElementById("job_image");
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
        .table-responsive.mt-5 {
            max-height: 800px;
        }
    </style>
</div>
