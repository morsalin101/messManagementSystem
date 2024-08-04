<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Meals</title>
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title">All Meals</h4>
                        <div>
                            <a href="<?=base_url('meal')?>" class="btn btn-secondary">Back</a>
                            <select class="form-control d-inline-block ml-2" id="mealFilter" style="width: 200px;">
                                <option value="">Filter by Member</option>
                                <!-- Filter options will be dynamically added here -->
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive mt-3" id="mealsTableContainer" style="display: none;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Launch</th>
                                    <th>Dinner</th>
                                    <th>Guest</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="todaysMealsTable">
                                <!-- Today's meals rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>
                    <div id="selectMessage" class="mt-3 text-center">
                        <p>Please select a member from the dropdown to view their meals.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Meal Modal -->
<div class="modal fade" id="mealModal" tabindex="-1" aria-labelledby="mealModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mealModalLabel">Edit Meal</h5>
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
                        <button type="submit" class="btn btn-primary" id="saveMealButton">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Meal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this meal?</p>
                <input type="hidden" id="deleteMealId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Fetch all meals
        function fetchAllMeals() {
            $.ajax({
                url: 'all-meals/ajax/get-all-meals',
                method: 'GET',
                success: function(response) {
                    populateMealFilter(response);
                },
                error: function() {
                    showNotification('Failed to fetch meals.', 'danger');
                }
            });
        }

        // Display meals in table
        function displayMeals(meals) {
            var mealsTable = $('#todaysMealsTable');
            mealsTable.empty(); // Clear existing rows

            meals.forEach(function(meal) {
                var row = '<tr>' +
                              '<td>' + meal.date + '</td>' +
                              '<td>' + meal.launch + '</td>' +
                              '<td>' + meal.dinner + '</td>' +
                              '<td>' + meal.guest + '</td>' +
                              '<td>' + meal.total + '</td>' +
                              '<td>' +
                                  '<button class="btn btn-secondary btn-sm editMealButton" data-id="' + meal.id + '" data-member-id="' + meal.member_id + '" data-date="' + meal.date + '" data-launch="' + meal.launch + '" data-dinner="' + meal.dinner + '" data-guest="' + meal.guest + '">Edit Meal</button> ' +
                                  '<button class="btn btn-danger btn-sm deleteMealButton" data-id="' + meal.id + '">Delete</button>' +
                              '</td>' +
                          '</tr>';
                mealsTable.append(row);
            });

            // Handle Edit Meal button click
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

            // Handle Delete Meal button click
            $('.deleteMealButton').click(function() {
                var mealId = $(this).data('id');
                $('#deleteMealId').val(mealId);
                $('#deleteModal').modal('show');
            });
        }

        // Populate the filter dropdown
        function populateMealFilter(meals) {
            var mealFilter = $('#mealFilter');
            var members = [...new Set(meals.map(meal => meal.name))]; // Get unique member names
            mealFilter.empty();
            mealFilter.append('<option value="">Filter by Member</option>');
            members.forEach(function(member) {
                mealFilter.append('<option value="' + member + '">' + member + '</option>');
            });

            // Handle filter change
            mealFilter.change(function() {
                var selectedMember = $(this).val();
                if (selectedMember) {
                    var filteredMeals = meals.filter(meal => meal.name === selectedMember);
                    displayMeals(filteredMeals);
                    $('#mealsTableContainer').show();
                    $('#selectMessage').hide();
                } else {
                    $('#mealsTableContainer').hide();
                    $('#selectMessage').show();
                }
            });
        }

        // Handle form submission for editing meal
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

            var url = 'all-meals/ajax/update-meal?id=' + formData.id;

            $.ajax({
                url: url,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    $('#mealModal').modal('hide');
                    showNotification('Meal updated successfully!', 'success');
                    location.reload(); // Reload the page
                },
                error: function() {
                    showNotification('Failed to save meal.', 'danger');
                }
            });
        });

        // Handle delete meal confirmation
        $('#confirmDeleteButton').click(function() {
            var mealId = $('#deleteMealId').val();
            $.ajax({
                url: 'all-meals/ajax/delete-meal?id=' + mealId,
                method: 'DELETE',
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    showNotification('Meal deleted successfully!', 'success');
                    fetchAllMeals(); // Refresh meals list
                },
                error: function() {
                    showNotification('Failed to delete meal.', 'danger');
                }
            });
        });

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

        // Initial fetch of all meals when the page loads
        fetchAllMeals();
    });
</script>
</body>
</html>
