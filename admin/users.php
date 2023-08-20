 <div class="container">
        <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            include(__DIR__ . '/../connect.php');
            $action = '';
            $user_id = '';
            $User_Type = '';
            $User_Email = '';
            $User_Password = '';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $action = $_POST['action'];
                $user_id = $_POST['User_ID'];
                $User_Type = $_POST['User_Type'];
                $User_Email = $_POST['User_Email'];
                $User_Password = $_POST['User_Password'];
                switch ($action) {
                    case 'insert':
                        $sql = "INSERT INTO Users (User_Type, User_Email, User_Password) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sss", $User_Type, $User_Email, $User_Password);
                        $stmt->execute();
                        break;
                    case 'update':
                        $sql = "UPDATE Users SET User_Type=?, User_Email=?, User_Password=? WHERE User_ID=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sssi", $User_Type, $User_Email, $User_Password, $user_id);
                        $stmt->execute();
                        break;
                    case 'delete':
                        $sql = "DELETE FROM Users WHERE User_ID=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        break;

                    case 'search':
                        $sql = "SELECT * FROM Users WHERE User_ID=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $user_id = $row['User_ID'];
                            $User_Type = $row['User_Type'];
                            $User_Email = $row['User_Email'];
                            $User_Password = $row['User_Password'];
                        } else {
                            echo "<div class='alert alert-warning'>No user found with the given ID</div>";
                        }

                    break;
                }
            }
        ?>

        <div class="row">

            <div class="col-md-4">
                <form id="searchForm" method="POST">
                    <div class="form-group">
                        <label for="User_ID">User ID:</label>
                        <input type="text" class="form-control" id="User_ID" name="User_ID" value="<?php echo $user_id; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="User_Type">User Type:</label>
                        <input type="text" class="form-control" id="User_Type" name="User_Type" value="<?php echo $User_Type; ?>">
                    </div>
                    <div class="form-group">
                        <label for="User_Email">User Email:</label>
                        <input type="text" class="form-control" id="User_Email" name="User_Email" value="<?php echo $User_Email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="User_Password">User Password:</label>
                        <input type="text" class="form-control" id="User_Password" name="User_Password" value="<?php echo $User_Password; ?>">
                    </div>
                    <div class="modal-footer ">
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
                $result = $conn->query("SELECT * FROM Users");
                if ($result->num_rows > 0) {
                ?>
                    <div class="table-responsive mt-5">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Type</th>
                                    <th>User Email</th>
                                    <th>User Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['User_ID']; ?></td>
                                        <td><?php echo $row['User_Type']; ?></td>
                                        <td><?php echo $row['User_Email']; ?></td>
                                        <td><?php echo $row['User_Password']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                } else {
                    echo "<div class='alert alert-info mt-5'>No users found</div>";
                }
                ?>
            </div>
        </div>

        <script>
            function clearForm() {
                document.getElementById("User_ID").value = "";
                document.getElementById("User_Type").value = "";
                document.getElementById("User_Email").value = "";
                document.getElementById("User_Password").value = "";
            }
        </script>

        <style>
            .button-container-custom .row{
                margin-bottom: 12px;
            }

            .button-container-custom .row .col-6{
                padding: 0 5px;
            }
            .button-container-custom .row .col-12{
                padding: 0 5px !important;
            }
        </style>

</div>