<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start a New Meal</title>
    <!-- Include Bootstrap CSS and jQuery -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
   
    <style>
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-left: 5px;
        }
        .status-active {
            background-color: green;
        }
        .status-closed {
            background-color: grey;
        }
    </style>
</head>
<body>

 <!-- Sale & Revenue Start -->
 <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="bi bi-cash-stack fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Today Deposite</p>
                                <h6 class="mb-0">1234৳</h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-money-bills fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Expense</p>
                                <h6 class="mb-0">1234৳</h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-bowl-food fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Today Meal</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Revenue</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <button class="btn btn-primary btn-sm" id="startMealButton">Start A New Meal</button>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title">Meal Information</h4>
                    <div class="row" id="mealCards">
                        <!-- Meal cards will be dynamically added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="startMealModal" tabindex="-1" aria-labelledby="startMealModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="startMealModalLabel">Start A New Meal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="startMealForm">
                    <div class="mb-3">
                        <label for="mealTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="mealTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="mealDate" class="form-label">Start Date</label>
                        <input type="text" class="form-control" id="mealDate" name="date" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteMealModal" tabindex="-1" aria-labelledby="deleteMealModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMealModalLabel">Delete Meal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this meal?</p>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var mealIdToDelete;

        // Show modal on button click
        $('#startMealButton').click(function() {
            $('#startMealModal').modal('show');
        });

        // Handle form submission
        $('#startMealForm').on('submit', function(e) {
            e.preventDefault();

            var formData = {
                title: $('#mealTitle').val(),
                date: $('#mealDate').val()
            };

            $.ajax({
                url: 'meal/ajax/start-meal',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    $('#startMealModal').modal('hide');
                    showNotification('Meal started successfully!', 'success');
                    fetchMeals(); // Refresh the meal list
                },
                error: function() {
                    showNotification('Failed to start the meal.', 'danger');
                }
            });
        });

        // Fetch all meals
        function fetchMeals() {
            $.ajax({
                url: 'meal/ajax/get-all-meals',
                method: 'GET',
                success: function(response) {
                    displayMeals(response);
                },
                error: function() {
                    showNotification('Failed to fetch meals.', 'danger');
                }
            });
        }

        // Display meals in cards
        function displayMeals(meals) {
            var mealCards = $('#mealCards');
            mealCards.empty(); // Clear existing cards

            meals.forEach(function(meal) {
                var statusIndicator = meal.status === 'active' ? 
                    '<span class="status-indicator status-active"></span>' : 
                    '<span class="status-indicator status-closed"></span>';

                var card = '<div class="col-md-4 mb-4">' +
                                '<div class="card">' +
                                    '<div class="card-body">' +
                                        '<h5 class="card-title">' + meal.title + '</h5>' +
                                        '<p class="card-text">Created At: ' + meal.created_at + '</p>' +
                                        '<p class="card-text">Finished At: ' + (meal.finished_at || 'Running') + '</p>' +
                                        '<p class="card-text">Status: ' + meal.status + statusIndicator + '</p>' +
                                        '<button class="btn btn-danger btn-sm closeMealButton" data-id="' + meal.id + '">Close</button> ' +
                                        '<button class="btn btn-warning btn-sm deleteMealButton" data-id="' + meal.id + '">Delete</button>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
                mealCards.append(card);
            });

            // Handle close button click
            $('.closeMealButton').click(function() {
                var mealId = $(this).data('id');

                $.ajax({
                    url: 'meal/ajax/update-meal?id=' + mealId,
                    method: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify({ status: 'closed' }),
                    success: function(response) {
                        showNotification('Meal closed successfully!', 'success');
                        fetchMeals(); // Refresh the meal list
                    },
                    error: function() {
                        showNotification('Failed to close the meal.', 'danger');
                    }
                });
            });

            // Handle delete button click
            $('.deleteMealButton').click(function() {
                mealIdToDelete = $(this).data('id');
                $('#deleteMealModal').modal('show');
            });

            // Confirm delete button click
            $('#confirmDeleteButton').click(function() {
                $.ajax({
                    url: 'meal/ajax/delete-meal?id=' + mealIdToDelete,
                    method: 'DELETE',
                    success: function(response) {
                        showNotification('Meal deleted successfully!', 'success');
                        fetchMeals(); // Refresh the meal list
                        $('#deleteMealModal').modal('hide');
                    },
                    error: function() {
                        showNotification('Failed to delete the meal.', 'danger');
                    }
                });
            });
        }

        // Function to show notification
        function showNotification(message, type) {
            var notification = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' + 
                                  message + 
                                  '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' + 
                                 '</div>');
            $('body').append(notification);

            setTimeout(function() {
                notification.alert('close');
            }, 3000);
        }

        // Initial fetch of meals when the page loads
        fetchMeals();
    });
</script>

</body>
</html>
