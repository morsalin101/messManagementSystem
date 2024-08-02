<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Majestic Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= base_url()?>/public/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/public/vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="<?= base_url()?>/public/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?= base_url()?>/public/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?= base_url()?>/public/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <h1>Welcome To Mess Management System</h1>
                                <!-- <img src="<?= base_url()?>/public/images/logo.svg" alt="logo"> -->
                            </div>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" id="loginForm">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" id="email" placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="password" placeholder="Password" required>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                                </div>
                                <!--
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            Keep me signed in
                                        </label>
                                    </div>
                                    <a href="#" class="auth-link text-black">Forgot password?</a>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Don't have an account? <a href="register.html" class="text-primary">Create</a>
                                </div>
                                -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(event) {
                event.preventDefault();

                var email = $('#email').val();
                var password = $('#password').val();
              

                var data = {};
                data['email'] = email;
                data['password'] = password;
                

                $.ajax({
                    url: "<?= base_url('login') ?>",
                    type: 'POST',
                    data: JSON.stringify(data),
                    success: function(response) {
                    
                        // Redirect or show success message
                         window.location.href = "<?= base_url('dashboard') ?>";
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error('Login failed:', error);
                        // Show error message
                    }
                });
            });
        });
    </script>
    <script src="<?= base_url()?>/public/vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="<?= base_url()?>/public/vendors/chart.js/Chart.min.js"></script>
    <script src="<?= base_url()?>/public/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="<?= base_url()?>/public/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="<?= base_url()?>/public/js/off-canvas.js"></script>
    <script src="<?= base_url()?>/public/js/hoverable-collapse.js"></script>
    <script src="<?= base_url()?>/public/js/template.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="<?= base_url()?>/public/js/dashboard.js"></script>
    <script src="<?= base_url()?>/public/js/data-table.js"></script>
    <script src="<?= base_url()?>/public/js/jquery.dataTables.js"></script>
    <script src="<?= base_url()?>/public/js/dataTables.bootstrap4.js"></script>
    <!-- End custom js for this page-->

    <script src="<?= base_url()?>/public/js/jquery.cookie.js" type="text/javascript"></script>
</body>

</html>
