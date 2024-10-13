@extends('layout.master')
@section('contents')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Player Information</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <style>
            /* Your existing CSS styles */
            body,
            html {
                margin: 0;
                padding: 0;
                font-family: 'Roboto', sans-serif;
                background-color: #f4f4f9;
            }

            .navbar {
                background-color: #4CAF50;
                color: white;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 20px;
            }

            .logo {
                font-size: 24px;
                font-weight: bold;
            }

            .profile-picture {
                position: relative;
                width: 50px;
                /* same size as original */
                height: 50px;
                /* same size as original */
                border-radius: 50%;
                overflow: hidden;
                display: inline-block;
            }

            .profile-picture img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
            }

            .profile-picture-container {
                position: relative;
                width: 150px;
                height: 150px;
                border-radius: 50%;
                margin-bottom: 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .profile-picture-container img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
            }

            .edit-icon {
                position: absolute;
                top: 10px;
                right: 10px;
                background-color: white;
                border-radius: 50%;
                padding: 5px;
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                color: #4CAF50;
            }

            .container {
                background-color: #ffffff;
                color: #333;
                padding: 30px;
                max-width: 700px;
                margin: 30px auto;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            .player-info {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .info-table {
                margin: auto;
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            .info-table th,
            .info-table td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: left;
            }

            .info-table th {
                background-color: #4CAF50;
                color: white;
                text-align: center;
            }

            .info-table td {
                background-color: #fff;
                color: #333;
                text-align: center;
            }

            h1,
            h2 {
                margin-bottom: 20px;
            }

            .btn-custom {
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
                padding: 15px 30px;
                font-size: 16px;
                border-radius: 8px;
                transition: background-color 0.3s ease, transform 0.3s ease;
            }

            .btn-custom:hover {
                background-color: #45a049;
                transform: translateY(-2px);
            }

            .modal-header {
                justify-content: center;
                border-bottom: none;
            }

            .button-group {
                display: flex;
                justify-content: center;
                margin-top: 30px;
            }

            .button-group .btn-custom {
                margin: 0 10px;
                min-width: 200px;
                /* Make the buttons the same size */
                height: 55px;
                /* Adjust height as needed */
            }

            .info-table .info-label {
                background-color: #4CAF50;
                color: white;
                text-align: center;
            }

            .container-bg {
                background-color: #f7f7f9;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            }

            .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.7); /* Black w/ opacity */
}

.modal-content {
    background-color: #ffffff;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    border-radius: 8px;
    width: 80%; /* Could be more or less, depending on screen size */
    max-width: 400px; /* Maximum width */
}

.close {
    color: #aaa;
    position: absolute; /* Position absolute within modal content */
    top: 10px; /* Adjust for positioning */
    right: 15px; /* Adjust for positioning */
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}


.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.subscription-heading {
    font-size: 30px; /* Adjust size as needed */
    color: #4CAF50; /* Set the color */
    margin-bottom: 15px; /* Optional: space below the heading */
}



        </style>
    </head>

    <body>
        <div class="container container-bg">
            <div class="player-info">
                <div class="profile-picture-container">
                    <img src="{{ $player['player_info']['PlayerInfo_Image'] }}" alt="Player Image" id="playerImage">
                    <div class="edit-icon" data-toggle="modal" data-target="#editImageModal">
                        <i class="fas fa-edit"></i>
                    </div>
                </div>
                <h1>Player Information</h1>
                @if (session('success'))
                    <div class="alert alert-success" id="success-alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" id="error-alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('isRedirectToLogin'))
                    <form id="logout-form-redirect" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <button id="logout-button-redirect" style="display: none;">Logout</button>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Submit the logout form after a few seconds
                            setTimeout(function() {
                                document.getElementById('logout-form-redirect').submit();
                            }, 3000); // Adjust the delay as needed
                        });
                    </script>
                @endif

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Hide success alert after 3 seconds
                        setTimeout(function() {
                            var successAlert = document.getElementById('success-alert');
                            if (successAlert) {
                                successAlert.style.display = 'none';
                            }
                        }, 3000);

                        // Hide error alert after 3 seconds
                        setTimeout(function() {
                            var errorAlert = document.getElementById('error-alert');
                            if (errorAlert) {
                                errorAlert.style.display = 'none';
                            }
                        }, 3000);
                    });
                </script>
                <table class="info-table">
                    <tr>
                        <th class="info-label"><strong>Name:</strong></th>
                        <td>{{ $player['player_info']['Player_Name'] }}</td>
                    </tr>
                    <tr>
                        <th class="info-label"><strong>Email Address:</strong></th>
                        <td>{{ $player['player_info']['Player_Email'] }}</td>
                    </tr>
                </table>

                <h2>Teams and Positions</h2>
                <table class="info-table">
                    <tr>
                        <th>#</th>
                        <th>Team</th>
                        <th>Primary Position</th>
                        <th>Secondary Position</th>
                    </tr>
                    @foreach ($player['players'] as $index => $playerDetail)
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- This adds the row number -->
                            <td>{{ $playerDetail['Team'] }}</td>
                            <td>{{ $playerDetail['PrimaryPosition'] }}</td>
                            <td>{{ $playerDetail['SecondaryPosition'] }}</td>
                        </tr>
                    @endforeach
                </table>

                <!-- Subscription Status Button -->
                <button type="button" class="btn-custom btn-small" style="padding: 5px 20px;" id="viewSubscriptionBtn">
                    View Subscription Status
                </button>


                <!-- Subscription Status Modal -->
<div id="subscriptionStatusModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
        <h2 class="subscription-heading">Current Subscription Plan</h2>

        @if ($errors->any())
            <p style="color: red;">
                {{ $errors->first() }}
            </p>
            <p>
                <strong>Please return to the homepage to see the subscription options.</strong>
            </p>
        @else
            <p>
                <strong>Current Plan:</strong>
                <span id="currentPlan">
                    {{ isset($plan) ? ucfirst($plan) : 'N/A' }}
                </span>
            </p>
            <p>
                <strong>Next Subscription Date:</strong>
                <span id="nextSubscriptionDate">
                    {{ isset($nextPaymentDate) ? $nextPaymentDate : 'N/A' }}
                </span>
            </p>
        @endif
        <button type="button" class="btn-custom" id="cancelSubscriptionBtn">Cancel Subscription</button>
    </div>
</div>












                <div class="button-group">
                    <button id="edit-info-btn" class="btn-custom" data-toggle="modal" data-target="#editInfoModal">
                        <i class="fas fa-edit"></i> Edit Player Information
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-custom">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Player Information Modal -->
        <div class="modal fade" id="editInfoModal" tabindex="-1" role="dialog" aria-labelledby="editInfoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editInfoModalLabel">Edit Player Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-info-form" method="POST" enctype="multipart/form-data"
                            action="{{ route('player.updateInfo') }}">
                            @csrf
                            <input type="hidden" name="player_info_id"
                                value="{{ $player['player_info']['PlayerInfo_ID'] }}">

                            <div class="form-group">
                                <label for="player_email">Email Address</label>
                                <input type="email" class="form-control" name="player_email"
                                    value="{{ $player['player_info']['Player_Email'] }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="player_name">Name</label>
                                <input type="text" class="form-control" name="player_name"
                                    value="{{ $player['player_info']['Player_Name'] }}">
                            </div>

                            <div class="form-group">
                                <label for="current_password">Enter Your Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                            </div>

                            <div class="form-group">
                                <label for="new_password">Enter A New Password</label>
                                <input type="password" class="form-control" name="new_password" id="new_password">
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">Re-Enter A New Password</label>
                                <input type="password" class="form-control" name="new_password_confirmation"
                                    id="new_password_confirmation">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn-custom">Update Information</button>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var editInfoForm = document.getElementById('edit-info-form');

                                    editInfoForm.onsubmit = function(event) {
                                        var newPassword = document.getElementById('new_password').value;
                                        var confirmPassword = document.getElementById('new_password_confirmation').value;
                                        var currentPassword = document.getElementById('current_password').value;

                                        if ((currentPassword && !newPassword) || (!currentPassword && newPassword)) {
                                            alert('Both current and new password are required.');
                                            event.preventDefault(); // Prevent form submission
                                            return false; // Ensure the form does not submit
                                        }

                                        if (newPassword !== confirmPassword) {
                                            alert('The passwords do not match. Please try again.');
                                            event.preventDefault(); // Prevent form submission
                                            return false; // Ensure the form does not submit
                                        }

                                        if ((newPassword && newPassword.length < 8) || (confirmPassword && confirmPassword.length <
                                                8)) {
                                            alert('The passwords must be more than 8 charanters.');
                                            event.preventDefault(); // Prevent form submission
                                            return false; // Ensure the form does not submit
                                        }

                                        // If passwords match, proceed with the form submission
                                        return true;
                                    };
                                });
                            </script>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Player Image Modal -->
        <div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="editImageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editImageModalLabel">Edit Player Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-image-form" method="POST" enctype="multipart/form-data"
                            action="{{ route('player.updateImage') }}">
                            @csrf
                            <input type="hidden" name="player_info_id"
                                value="{{ $player['player_info']['PlayerInfo_ID'] }}">

                            <div class="form-group">
                                <label for="player_image">Update Player Image</label>
                                <input type="file" class="form-control" name="player_image" id="player_image"
                                    accept="image/*">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn-custom">Update Image</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editInfoForm = document.getElementById('edit-info-form');

                editInfoForm.onsubmit = function(event) {
                    event.preventDefault();

                    var newPassword = document.getElementById('new_password').value;
                    var confirmPassword = document.getElementById('new_password_confirmation').value;

                    if (newPassword !== confirmPassword) {
                        alert('The passwords do not match. Please try again.');
                        return; // Prevent form submission
                    }

                    var formData = new FormData(editInfoForm);
                    var playerId = formData.get('player_info_id');
                    var data = {};

                    if (formData.get('player_name')) {
                        data.Player_Name = formData.get('player_name');
                    }
                    if (formData.get('current_password') && formData.get('new_password')) {
                        data.current_password = formData.get('current_password');
                        data.new_password = formData.get('new_password');
                    }

                    fetch(`http://143.198.209.104/api/playersinfo/update-credentials/${playerId}`, {
                            method: 'PUT',
                            body: JSON.stringify(data),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Information updated successfully.');

                                // Automatically log out the session after updating the information
                                document.getElementById('logout-form').submit();
                            } else {
                                alert(`Failed to update information: ${data.message}`);
                            }
                        })
                        .catch(error => {
                            console.error('Error updating information:', error);
                            alert('An error occurred while updating information.');
                        });

                    $('#editInfoModal').modal('hide');
                };
            });
        </script> --}}

<script>
    // Get modal elements
    const modal = document.getElementById('subscriptionStatusModal');
    const viewSubscriptionBtn = document.getElementById('viewSubscriptionBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelSubscriptionBtn = document.getElementById('cancelSubscriptionBtn');

    /// Open modal when the button is clicked
viewSubscriptionBtn.onclick = function() {
    // Fetch the subscription data from the server
    fetch("{{ route('subscription.modal') }}")
        .then(response => {
            if (!response.ok) {
                // Redirect to home if the response is not okay (not subscribed)
                window.location.href = "{{ route('home') }}"; // Redirect to home.blade.php
                return; // Prevent further processing
            }
            return response.json(); // Ensure you are returning JSON here
        })
        .then(data => {
            // Check if the response contains an error
            if (data.error) {
                // Redirect to home if an error is returned from the API (not subscribed)
                window.location.href = "{{ route('home') }}"; // Redirect to home.blade.php
            } else {
                // Update modal with subscription data
                document.getElementById('currentPlan').innerHTML = data.plan ? (data.plan === 'yearly' ? 'Yearly' : 'Monthly') : 'N/A';
                document.getElementById('nextSubscriptionDate').innerHTML = data.nextPaymentDate ? data.nextPaymentDate : 'N/A';

                // Show the modal
                modal.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error fetching subscription data:', error);
            // Redirect to home on error
            window.location.href = "{{ route('home') }}"; // Redirect to home.blade.php
        });
}



    // Close modal when the close button (X) is clicked
    closeModalBtn.onclick = function() {
        modal.style.display = 'none';
    }

    // Cancel subscription functionality
    // Cancel subscription functionality
cancelSubscriptionBtn.onclick = function() {
    const playerId = {{ $player['player_info']['PlayerInfo_ID'] }}; // Ensure you have the PlayerInfo_ID

    fetch("{{ route('subscription.cancel') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
        },
        body: JSON.stringify({ PlayerInfo_ID: playerId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            alert(data.message); // Show success message
            modal.style.display = 'none'; // Close modal after cancellation
        }
    })
    .catch(error => {
        console.error('Error canceling subscription:', error);
        alert('Failed to cancel subscription. Please try again.');
    });
}


    // Close modal if user clicks outside of it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
</script>







    </body>

    </html>
@endsection
