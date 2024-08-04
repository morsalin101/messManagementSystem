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
    <div class="row g-4">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title">Today's Meals</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <div class="row py-2">
                            <div class="col">
                                <h2 ></h2>
                            </div>
                            <div class="col-auto">
                                <a href="<?=base_url('all-meals')?>"><button class="btn btn-info "><i class="fa-solid fa-list"></i> Click Here To View This Month All Meal</button></a>
                            </div>
                        </div>
                                <tr>
                                    <th>Member Name</th>
                                    <th>Date</th>
                                    <th>Launch</th>
                                    <th>Dinner</th>
                                    <th>Guest</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="todaysMealsTable">
                                <!-- Today's meals rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Meal Modal -->
<div class="modal fade" id="mealModal" tabindex="-1" aria-labelledby="mealModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mealModalLabel">Add/Edit Meal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="mealForm">
                    <input type="hidden" id="mealId" name="meal_id">
                    <input type="hidden" id="memberId" name="member_id">
                    <div class="mb-3">
                        <label for="mealDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="mealDate" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="mealLaunch" class="form-label">Launch</label>
                        <input type="text" class="form-control" id="mealLaunch" name="launch" required>
                    </div>
                    <div class="mb-3">
                        <label for="mealDinner" class="form-label">Dinner</label>
                        <input type="text" class="form-control" id="mealDinner" name="dinner" required>
                    </div>
                    <div class="mb-3">
                        <label for="mealGuest" class="form-label">Guest</label>
                        <input type="number" class="form-control" id="mealGuest" name="guest" value="0" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveMealButton">Save Meal</button>
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
            },
            error: function() {
                showNotification('Failed to fetch members.', 'danger');
            }
        });
    }

    // Fetch today's meals
    function fetchTodaysMeals() {
        $.ajax({
            url: 'individual-meal/ajax/get-todays-meals',
            method: 'GET',
            success: function(response) {
                displayTodaysMeals(response);
            },
            error: function() {
                showNotification('Failed to fetch today\'s meals.', 'danger');
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
                              '<button class="btn btn-primary btn-sm addMealButton" data-id="' + member.id + '">Add Meal</button>' +
                          '</td>' +
                      '</tr>';
            membersTable.append(row);
        });

        // Handle Add Meal button click
        $('.addMealButton').click(function() {
            var memberId = $(this).data('id');
            clearMealForm();
            $('#memberId').val(memberId);
            $('#mealModalLabel').text('Add Meal');
            $('#saveMealButton').text('Add Meal');
            $('#mealModal').modal('show');
        });
    }

    // Display today's meals in table
    function displayTodaysMeals(meals) {
        var todaysMealsTable = $('#todaysMealsTable');
        todaysMealsTable.empty(); // Clear existing rows

        var today = new Date();
        var todayFormatted = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');

        meals.forEach(function(meal) {
            if (meal.date === todayFormatted) {
                var row = '<tr>' +
                              '<td>' + meal.name + '</td>' +
                              '<td>' + meal.date + '</td>' +
                              '<td>' + meal.launch + '</td>' +
                              '<td>' + meal.dinner + '</td>' +
                              '<td>' + meal.guest + '</td>' +
                              '<td>' +
                                  '<button class="btn btn-secondary btn-sm editMealButton" data-id="' + meal.id + '" data-member-id="' + meal.member_id + '" data-date="' + meal.date + '" data-launch="' + meal.launch + '" data-dinner="' + meal.dinner + '" data-guest="' + meal.guest + '">Edit Meal</button>' +
                              '</td>' +
                          '</tr>';
                todaysMealsTable.append(row);
            }
        });

        // Handle Edit Meal button click for today's meal
        $('.editMealButton').click(function() {
            var mealId = $(this).data('id');
            var memberId = $(this).data('member-id');
            var date = $(this).data('date');
            var launch = $(this).data('launch');
            var dinner = $(this).data('dinner');
            var guest = $(this).data('guest');

            $('#mealId').val(mealId);
            $('#memberId').val(memberId);
            $('#mealDate').val(date);
            $('#mealLaunch').val(launch);
            $('#mealDinner').val(dinner);
            $('#mealGuest').val(guest);

            $('#mealModalLabel').text('Edit Meal');
            $('#saveMealButton').text('Save Changes');
            $('#mealModal').modal('show');
        });
    }

    // Handle form submission for adding/editing meal
    $('#mealForm').on('submit', function(e) {
        e.preventDefault();

        var formData = {
            id: $('#mealId').val(),
            member_id: $('#memberId').val(),
            date: $('#mealDate').val(),
            launch: $('#mealLaunch').val(),
            dinner: $('#mealDinner').val(),
            guest: $('#mealGuest').val()
        };

        var url = formData.id ? 'individual-meal/ajax/update-meal?id=' + formData.id : 'individual-meal/ajax/add-meal?id=' + formData.member_id;
        var method = formData.id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(response) {
                $('#mealModal').modal('hide');
                var action = formData.id ? 'updated' : 'added';
                showNotification('Meal ' + action + ' successfully!', 'success');
                fetchMembers(); // Refresh the members list
                fetchTodaysMeals(); // Refresh today's meals list
            },
            error: function() {
                showNotification('Failed to save meal.', 'danger');
            }
        });
    });

    // Function to clear the meal form
    function clearMealForm() {
        $('#mealForm')[0].reset();
        $('#mealId').val('');
        $('#memberId').val('');
        $('#mealDate').val('');
        $('#mealLaunch').val('');
        $('#mealDinner').val('');
        $('#mealGuest').val('0');
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

    // Initial fetch of members and today's meals when the page loads
    fetchMembers();
    fetchTodaysMeals();
});

</script>

</body>
</html>
