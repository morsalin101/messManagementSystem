<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Include jQuery and Bootstrap CSS/JS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="alert" id="notification" style="display:none;"></div>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4"><?= $page_title ?></h6>
                
                <div class="table-responsive">
                    <table class="table" id="userTable">
                        <thead>
                        <div class="row py-2">
                            <div class="col">
                                <h2 ></h2>
                            </div>
                            <div class="col-auto">
                            <?php if ($role == 'manager'): ?>
                                <button class="btn btn-info btn-add-member" data-bs-toggle="modal" data-bs-target="#addMemberModal"><i class="bi bi-plus-circle"></i>Add Member</button>
                            <?php endif; ?>
                            </div>
                        </div>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Role</th>
                                <?php if ($role == 'manager'): ?>
                                <th scope="col">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    var tbody = $('#userTable tbody');
                    tbody.empty(); // Clear existing rows

                    $.each(response, function(index, member) {
                        var row = '<tr>' +
                                  '<td>' + member.name + '</td>' +
                                  '<td>' + member.email + '</td>' +
                                  '<td>' + member.phone + '</td>' +
                                  '<td>' + member.role + '</td>' +
                                  <?php if ($role == 'manager'): ?>
                                  '<td>' +
                                  '<button class="btn btn-primary edit-member" data-id="' + member.id + '" data-name="' + member.name + '" data-email="' + member.email + '" data-phone="' + member.phone + '" data-role="' + member.role + '"><i class="bi bi-pencil-square"></i></button>' +
                                  '<button class="btn btn-danger delete-member" data-id="' + member.id + '"><i class="bi bi-trash"></i></button>' +
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
            $('#role').val('user');
        });
    });
</script>

</body>
</html>
