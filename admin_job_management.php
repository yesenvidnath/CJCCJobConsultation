<?php
  include('template_parts/header-footer/header-admin.php');
  //Connnection methode
  include('connect.php');
?>

<section class="admin-dashbord-section">

    <?php
    include('admin/jobs.php');
    ?>

</section>

<?php
  include('template_parts/header-footer/footer-admin.php');
?>
<script src="js/pop.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.6/dist/umd/popper.min.js"></script>