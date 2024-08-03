<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $page_title ?></title>
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
  
  <style>
    .full-height {
        height: 100vh;
    }
    .full-width {
        width: 100%;
    }
    .no-padding {
        padding: 0;
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .alert {
        position: fixed;
        top: 70px;
        right: 20px;
        z-index: 1000;
        display: none;
        padding: 15px;
        background-color: #28a745;
        color: white;
        border-radius: 5px;
    }
  </style>
</head>

<body>
    <div class="alert" id="notification"></div>

    <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin">
              <div class="card">
                <div class="card-body">
                <div class="col-md-12 stretch-card full-height no-padding">
            <div class="card full-width full-height no-padding">
                <div class="card-header">
                    <h4 class="card-title"><?= $page_title ?></h4>
                    <?php if ($role == 'manager'): ?>
                    <div class="col-auto">
                        <button class="btn btn-primary btn-add-member" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                            <i class="fa-solid fa-plus mx-1"></i>Add Member
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-body full-height no-padding">
                    <div class="table-responsive full-height no-padding">
                        <table id="recent-purchases-listing" class="table border border-solid full-width">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <?php if ($role == 'manager'): ?>
                                    <th>Action</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated by AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

 

                </div>
              </div>
            </div>
          </div>
        </div>
     
      </div>
        <!-- content-wrapper ends -->
    
    <!-- container-fluid -->

    <!-- Modal -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Add Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addMemberForm">
                        <input type="hidden" id="memberModalAction" value="add">
                        <input type="hidden" id="editMemberId">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="user">User</option>
                                <option value="manager">Manager</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteMemberModal" tabindex="-1" aria-labelledby="deleteMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMemberModalLabel">Delete Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this member?</p>
                    <input type="hidden" id="deleteMemberId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
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
    
    <!-- Custom JS for AJAX call -->
    <script>
        $(document).ready(function() {
            // Fetch members and populate the table
            fetchMembers();

            // Function to fetch members
            function fetchMembers() {
                $.ajax({
                    url: '<?= base_url('get-members') ?>',
                    method: 'GET',
                    success: function(response) {
                        var tbody = $('#recent-purchases-listing tbody');
                        tbody.empty(); // Clear existing rows

                        $.each(response, function(index, member) {
                            var row = '<tr>' +
                                      '<td>' + member.name + '</td>' +
                                      '<td>' + member.email + '</td>' +
                                      '<td>' + member.phone + '</td>' +
                                      '<td>' + member.role + '</td>' +
                                      <?php if ($role == 'manager'): ?>
                                      '<td>' +
                                      '<button class="btn btn-primary edit-member" data-id="' + member.id + '" data-name="' + member.name + '" data-email="' + member.email + '" data-phone="' + member.phone + '" data-role="' + member.role + '">Edit</button>' +
                                      '<button class="btn btn-danger delete-member" data-id="' + member.id + '">Delete</button>' +
                                      '</td>' +
                                      <?php endif; ?>
                                      '</tr>';
                            tbody.append(row);
                        });
                    }
                });
            }

            // Function to show notification
            function showNotification(message, type) {
                var notification = $('#notification');
                notification.removeClass();
                notification.addClass('alert alert-' + type);
                notification.text(message);
                notification.fadeIn();

                setTimeout(function() {
                    notification.fadeOut();
                }, 2000);
            }

            // Handle form submission for adding/editing a member
            $('#addMemberForm').on('submit', function(e) {
                e.preventDefault();

                var action = $('#memberModalAction').val();
                var memberId = $('#editMemberId').val();
                var formData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    role: $('#role').val()
                };

                var url = action === 'add' ? '<?= base_url('ajax/add-member') ?>' : '<?= base_url('ajax/update-member') ?>' + '?id=' + memberId;
                var method = action === 'add' ? 'POST' : 'PUT';

                $.ajax({
                    url: url,
                    method: method,
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        $('#addMemberModal').modal('hide');
                        fetchMembers(); // Refresh the members list
                        showNotification(action === 'add' ? 'Member added successfully!' : 'Member updated successfully!', 'success');
                    }
                });
            });

            // Open modal with member data for editing
            $(document).on('click', '.edit-member', function() {
                var memberId = $(this).data('id');
                var memberName = $(this).data('name');
                var memberEmail = $(this).data('email');
                var memberPhone = $(this).data('phone');
                var memberRole = $(this).data('role');

                $('#memberModalAction').val('edit');
                $('#addMemberModalLabel').text('Edit Member');
                $('#editMemberId').val(memberId);
                $('#name').val(memberName);
                $('#email').val(memberEmail);
                $('#phone').val(memberPhone);
                $('#role').val(memberRole);

                $('#addMemberModal').modal('show');
            });

            // Handle delete operation
            $(document).on('click', '.delete-member', function() {
                var memberId = $(this).data('id');
                $('#deleteMemberId').val(memberId);
                $('#deleteMemberModal').modal('show');
            });

            // Confirm delete operation
            $('#confirmDeleteButton').on('click', function() {
                var memberId = $('#deleteMemberId').val();
                $.ajax({
                    url: '<?= base_url('ajax/delete-member') ?>' + '?id=' + memberId,
                    method: 'DELETE',
                    success: function(response) {
                        $('#deleteMemberModal').modal('hide');
                        fetchMembers(); // Refresh the members list
                        showNotification('Member deleted successfully!', 'success');
                    }
                });
            });

            // Handle add member button click
            $(document).on('click', '.btn-add-member', function() {
                $('#memberModalAction').val('add');
                $('#addMemberModalLabel').text('Add Member');
                $('#editMemberId').val('');
                $('#name').val('');
                $('#email').val('');
                $('#phone').val('');
                $('#role').val('User');
            });
        });
    </script>
</body>

</html>
