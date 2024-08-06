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
                                <p class="mb-2">Count Meal</p>
                                <h6 class="mb-0">0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-chart-simple fa-3x text-primary"></i> 
                            <div class="ms-3">
                                <p class="mb-2">Meal Rate</p>
                                <h6 class="mb-0">1234৳</h6>
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

</script>

</body>
</html>
