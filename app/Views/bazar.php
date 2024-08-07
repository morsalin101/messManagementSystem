<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start a New Bazar</title>
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
    <!-- Sale & Revenue End -->
    
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <button class="btn btn-primary btn-sm" id="startBazarButton">Add Today's Bazar</button>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title">Bazar Information Of This Month</h4>
                        <div class="row" id="bazarCards">
                            <!-- Bazar cards will be dynamically added here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="bazarModal" tabindex="-1" aria-labelledby="bazarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bazarModalLabel">Start A New Bazar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bazarForm">
                    <input type="hidden" id="bazarId" name="id">
                    <div class="mb-3">
                        <label for="bazarDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="bazarDate" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="bazarDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="bazarDetails" name="details" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="bazarTotal" class="form-label">Total</label>
                        <input type="number" class="form-control" id="bazarTotal" name="total" required>
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
<div class="modal fade" id="deleteBazarModal" tabindex="-1" aria-labelledby="deleteBazarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBazarModalLabel">Delete Bazar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this bazar?</p>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="notification" id="notificationContainer"></div>

<script>
    $(document).ready(function() {
        function fetchBazars() {
            $.ajax({
                url: "<?= base_url('bazar/ajax/get-all-bazars') ?>",
                method: 'GET',
                success: function(data) {
                    $('#bazarCards').empty();
                    data.forEach(function(bazar) {
                        $('#bazarCards').append(`
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body" 
                                         data-id="${bazar.id}"
                                         data-date="${bazar.date}"
                                         data-details="${bazar.details}"
                                         data-total="${bazar.total}">
                                        <h5 class="card-title">Bazar on ${bazar.date}</h5>
                                        <p class="card-text">Name: ${bazar.member_name}</p>
                                        <p class="card-text">Details: ${bazar.details}</p>
                                        <p class="card-text">Total: ${bazar.total} ৳</p>
                                        <button class="btn btn-primary btn-sm editBazarButton">Edit</button>
                                        <button class="btn btn-danger btn-sm deleteBazarButton" data-id="${bazar.id}">Delete</button>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }
            });
        }

        $('#startBazarButton').click(function() {
            $('#bazarForm')[0].reset();
            $('#bazarId').val('');
            $('#bazarModalLabel').text('Start A New Bazar');
            $('#bazarModal').modal('show');
        });

        $(document).on('click', '.editBazarButton', function() {
            const cardBody = $(this).closest('.card-body');
            const id = cardBody.data('id');
            const date = cardBody.data('date');
            const details = cardBody.data('details');
            const total = cardBody.data('total');

            $('#bazarId').val(id);
            $('#bazarDate').val(date);
            $('#bazarDetails').val(details);
            $('#bazarTotal').val(total);
            $('#bazarModalLabel').text('Edit Bazar');
            $('#bazarModal').modal('show');
        });

        $('#bazarForm').submit(function(e) {
            e.preventDefault();
            const id = $('#bazarId').val();
            const url = id ? "<?= base_url('bazar/ajax/edit-bazar/') ?>" + id : "<?= base_url('bazar/ajax/add-bazar') ?>";
            const method = id ? 'PUT' : 'POST';
            const data = {
                date: $('#bazarDate').val(),
                details: $('#bazarDetails').val(),
                total: $('#bazarTotal').val()
            };

            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    $('#bazarModal').modal('hide');
                    fetchBazars();
                    showNotification(response.message, response.status === 'error' ? 'danger' : 'success');
                },
                error: function() {
                    showNotification('Error saving bazar', 'danger');
                }
            });
        });

        $(document).on('click', '.deleteBazarButton', function() {
            const id = $(this).data('id');
            $('#confirmDeleteButton').data('id', id);
            $('#deleteBazarModal').modal('show');
        });

        $('#confirmDeleteButton').click(function() {
            const id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('bazar/ajax/delete-bazar/') ?>" + id,
                method: 'DELETE',
                success: function() {
                    $('#deleteBazarModal').modal('hide');
                    fetchBazars();
                    showNotification('Bazar deleted successfully', 'success');
                },
                error: function() {
                    showNotification('Error deleting bazar', 'danger');
                }
            });
        });

        function showNotification(message, type) {
            const notification = $(`
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            $('#notificationContainer').append(notification);
            setTimeout(function() {
                notification.alert('close');
            }, 2000);
        }

        fetchBazars();
    });
</script>

</body>
</html>
