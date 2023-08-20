<footer class="bg-light text-dark py-4 ">
    <div class="container">
        <div class="row">
            <!-- Email Subscription Form -->
            <div class="col-md-3">
                <h5>Email Subscription</h5>
                <form>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Enter your email">
                    </div>
                    <button type="submit" class="btn btn-success">Subscribe Us Now</button>
                </form>
            </div>
            <!-- Company Name -->
            <div class="col-md-3">
                <h5>Colombo Job Consultation</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <!-- Menu -->
            <div class="col-md-3">
                <h5>Menu</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <!-- Social Media Icons -->
            <div class="col-md-3">
                <h5>Follow Us</h5>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#"><i class="fab fa-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fab fa-linkedin"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Add this line to include Bootstrap and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Applynow button funtonality -->
    <script>
        function applyNow(jobId) {
            // Check if the user is logged in
            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_type'])) { ?>
                var loggedInUserType = "<?php echo $_SESSION['user_type']; ?>";
                // Check if the user is an Applicant
                if (loggedInUserType === 'JobSeeker') {
                    // Redirect to the Apply page with the job ID
                    window.location.href = 'Apply.php?job_id=' + jobId;
                } else {
                    // Show a JS message and redirect to the home page
                    alert('Consultants can\'t apply for jobs.');
                    window.location.href = 'index.php';
                }
            <?php } else { ?>
                // Redirect to the login page
                window.location.href = 'login.php';
            <?php } ?>
        }
    </script>
</body>
</html>