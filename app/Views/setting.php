<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div class="container-fluid pt-4 px-4">
        <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
            <div class="col-12 col-sm-8">
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" placeholder="Name">
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com">
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="password" placeholder="Password">
                        <label for="password">Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4" id="saveChanges">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Assuming you have the user ID stored in a variable
            var userId = 1; // Replace with the actual user ID

            // Fetch user data when the page loads
            fetchUserData(userId);

            // Update user data when the Save Changes button is clicked
            $('#saveChanges').click(function (event) {
                event.preventDefault();
                updateUserData(userId);
            });
        });

        function fetchUserData(userId) {
            $.ajax({
                url: '<?= base_url('setting/ajax/get') ?>',
                method: 'GET',
                data: { id: userId },
                dataType: 'json',
                success: function (data) {
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    // Note: Normally, you would not populate the password field
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching user data:', error);
                }
            });
        }

        function updateUserData(userId) {
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
                url: '<?= base_url('setting/ajax/update') ?>',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ id: userId, name: name, email: email, password: password }),
                success: function (data) {
                    alert('User data updated successfully');
                },
                error: function (xhr, status, error) {
                    console.error('Error updating user data:', error);
                }
            });
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
