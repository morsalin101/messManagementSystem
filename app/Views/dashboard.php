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
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
    </style>
</head>
<body>

<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
     <!-- Sale & Revenue Start -->
<?php if ($role == 'manager'): ?>
    <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">This Month Summary</h4>
                <div class="row">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-money-bill fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Deposit</p>
                                <h6 class="mb-0"><?= $total_money?>৳</h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-money-bills fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Expense</p>
                                <h6 class="mb-0"><?= number_format($total_bazar,3)?>৳</h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-bowl-food fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Count Meal</p>
                                <h6 class="mb-0"><?= $total_meals?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-chart-simple fa-3x text-primary"></i> 
                            <div class="ms-3">
                                <p class="mb-2">Meal Rate</p>
                                <h6 class="mb-0"><?= number_format($meal_rate,3)?>৳</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<!-- Summary End -->
            <!-- Sale & Revenue End -->
 <!-- Sale & Revenue Start -->
 <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Your Summary</h4>
                <div class="row">
                    <div class="col-12 col-sm-6 col-xl">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-money-bill fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Deposit</p>
                                <h6 class="mb-0"><?= $your_deposite ?>৳</h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-xl">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-money-bills fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Expense</p>
                                <h6 class="mb-0"><?= number_format($your_expense, 3) ?>৳</h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-xl">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-money-bills fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Meal Rate</p>
                                <h6 class="mb-0"><?= number_format($meal_rate, 3) ?>৳</h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-xl">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-bowl-food fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Count Meal</p>
                                <h6 class="mb-0"><?= $your_total_meals ?></h6>
                            </div>
                        </div>
                    </div>
                    
                     
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Summary End -->

<?php if ($role == 'manager'): ?>
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
<?php endif; ?>

<!-- Meal Table -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title">This Month Your All Meals</h4>
                        <div>
                           
                        </div>
                    </div>
                    <div class="table-responsive mt-3" id="mealsTableContainer">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Lunch</th>
                                    <th>Dinner</th>
                                    <th>Guest</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Meal Table End -->
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
                        <input type="date" class="form-control" id="mealDate" name="date" required>
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

<div class="notification" id="notificationContainer"></div>

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
                    if (response.status === 'success') {
                        $('#startMealModal').modal('hide');
                        showNotification('Meal started successfully!', 'success');
                        fetchMeals(); // Refresh the meal list
                    } else if (response.status === 'error') {
                        $('#startMealModal').modal('hide');
                        showNotification(response.message, 'danger');
                    }
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

        // Fetch user's meals
        function fetchUserMeals() {
            $.ajax({
                url: 'individual-meal/ajax/your-meal',
                method: 'GET',
                success: function(response) {
                    displayUserMeals(response);
                },
                // error: function() {
                //     showNotification('Failed to fetch your meals.', 'danger');
                // }
            });
        }

        // Display user's meals in table
        function displayUserMeals(meals) {
            var tableBody = $('#mealsTableContainer tbody');
            tableBody.empty(); // Clear existing rows

            meals.forEach(function(meal) {
                var row = '<tr>' +
                            '<td>' + meal.date + '</td>' +
                            '<td>' + meal.launch + '</td>' +
                            '<td>' + meal.dinner + '</td>' +
                            '<td>' + meal.guest + '</td>' +
                            '<td>' + meal.total + '</td>' +
                          '</tr>';
                tableBody.append(row);
            });
        }

        // Function to show notification
        function showNotification(message, type) {
            var notification = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' + 
                                  message + 
                                  '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' + 
                                 '</div>');
            $('#notificationContainer').append(notification);

            setTimeout(function() {
                notification.alert('close');
            }, 3000);
        }

        // Initial fetch of meals when the page loads
        fetchMeals();
        fetchUserMeals();
    });
</script>

</body>
</html>
