<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Management</title>
    <!-- Include jQuery and Bootstrap CSS/JS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            display: none;
        }
    </style>
</head>
<body>
<div class="alert notification" id="notification"></div>

<div class="container-fluid pt-4 px-4">
<?php if ($role == 'manager'): ?>
    <div class="row g-4">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title">Members</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="membersTable">
                                <!-- Member rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row g-4">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title">Member Depositions</h4>
                    <div class="form-group">
                        <div></div>
                        <div class="float-end">
                        <!-- <label for="memberSelect">Select Member:</label> -->
                        <select class="form-control" id="memberSelect">
                            <option value="">Select a member</option>
                        </select>
                        </div>
                        
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Deposite</th>
                                </tr>
                            </thead>
                            <tbody id="depositionsTable">
                                <!-- Deposition rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Money Modal -->
<div class="modal fade" id="moneyModal" tabindex="-1" aria-labelledby="moneyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moneyModalLabel">Add/Edit Money</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="moneyForm">
                    <input type="hidden" id="moneyId" name="money_id">
                    <input type="hidden" id="memberId" name="member_id">
                    <div class="mb-3">
                        <label for="moneyDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="moneyDate" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="moneyAmount" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="moneyAmount" name="deposite" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveMoneyButton">Save Money</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Fetch all members
        function fetchMembers() {
            $.ajax({
                url: 'get-members',
                method: 'GET',
                success: function(response) {
                    displayMembers(response);
                    populateMemberSelect(response);
                },
                error: function() {
                    showNotification('Failed to fetch members.', 'danger');
                }
            });
        }

        // Display members in table
        function displayMembers(members) {
            var membersTable = $('#membersTable');
            membersTable.empty(); // Clear existing rows

            members.forEach(function(member) {
                var row = '<tr>' +
                              '<td>' + member.name + '</td>' +
                              '<td>' + member.email + '</td>' +
                              '<td>' + member.phone + '</td>' +
                              '<td>' +
                                  '<button class="btn btn-primary btn-sm addMoneyButton" data-id="' + member.id + '">Add Money</button>' +
                              '</td>' +
                          '</tr>';
                membersTable.append(row);
            });

            // Handle Add Money button click
            $('.addMoneyButton').click(function() {
                var memberId = $(this).data('id');
                clearMoneyForm();
                $('#memberId').val(memberId);
                $('#moneyModalLabel').text('Add Money');
                $('#saveMoneyButton').text('Add Money');
                $('#moneyModal').modal('show');
            });
        }

        // Populate the member select dropdown
        function populateMemberSelect(members) {
            var memberSelect = $('#memberSelect');
            memberSelect.empty(); // Clear existing options

            memberSelect.append('<option value="">Select a member</option>');

            members.forEach(function(member) {
                var option = '<option value="' + member.id + '">' + member.name + '</option>';
                memberSelect.append(option);
            });
        }

        // Fetch depositions for the selected member
        function fetchDepositions(memberId) {
            $.ajax({
                url: 'money/ajax/get-depositions?id=' + memberId,
                method: 'GET',
                success: function(response) {
                    displayDepositions(response);
                },
                error: function() {
                    showNotification('Failed to fetch depositions.', 'danger');
                }
            });
        }

        // Display depositions in table
        function displayDepositions(depositions) {
            var depositionsTable = $('#depositionsTable');
            depositionsTable.empty(); // Clear existing rows

            depositions.forEach(function(deposition) {
                var row = '<tr>' +
                              '<td>' + deposition.date + '</td>' +
                              '<td>' + deposition.deposite + '</td>' +
                          '</tr>';
                depositionsTable.append(row);
            });
        }

        // Handle member selection change
        $('#memberSelect').change(function() {
            var memberId = $(this).val();
            if (memberId) {
                fetchDepositions(memberId);
            } else {
                $('#depositionsTable').empty(); // Clear depositions table if no member selected
            }
        });

        // Handle form submission for adding/editing money
        $('#moneyForm').on('submit', function(e) {
            e.preventDefault();

            var formData = {
                id: $('#moneyId').val(),
                member_id: $('#memberId').val(),
                date: $('#moneyDate').val(),
                deposite: $('#moneyAmount').val()
            };

            var url = formData.id ? 'money/ajax/update-money?id=' + formData.id : 'money/ajax/add-money?id=' + formData.member_id;
            var method = formData.id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    $('#moneyModal').modal('hide');
                    var action = formData.id ? 'updated' : 'added';
                    if (response.status === 'error') {
                        showNotification(response.message, 'danger');
                    } else {
                        showNotification('Money ' + action + ' successfully!', 'success');
                    }
                    fetchMembers(); // Refresh the members list
                    fetchDepositions(formData.member_id); // Refresh depositions list for the member
                },
                error: function() {
                    showNotification('Failed to save money.', 'danger');
                }
            });
        });

        // Function to clear the money form
        function clearMoneyForm() {
            $('#moneyForm')[0].reset();
            $('#moneyId').val('');
            $('#memberId').val('');
            $('#moneyDate').val('');
            $('#moneyAmount').val('');
        }

        // Function to show notification
        function showNotification(message, type) {
            var notification = $('#notification');
            notification.removeClass();
            notification.addClass('alert notification alert-' + type);
            notification.text(message);
            notification.fadeIn();

            setTimeout(function() {
                notification.fadeOut();
            }, 2000); // 2 seconds
        }

        // Initial fetch of members when the page loads
        fetchMembers();
    });
</script>
</body>
</html>
