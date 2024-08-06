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
        body, html {
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
            width: 50px; /* same size as original */
            height: 50px; /* same size as original */
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

        .info-table th, .info-table td {
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

        h1, h2 {
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
            min-width: 200px; /* Make the buttons the same size */
            height: 55px; /* Adjust height as needed */
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <div class="container container-bg">
        <div class="player-info">
            <div class="profile-picture-container">
                <img src="{{ $player['player_info']['PlayerInfo_Image'] }}" alt="Player Image">
                <div class="edit-icon" data-toggle="modal" data-target="#editInfoModal">
                    <i class="fas fa-edit"></i>
                </div>
            </div>
            <h1>Player Information</h1>
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
                    <th>Team</th>
                    <th>Primary Position</th>
                    <th>Secondary Position</th>
                </tr>
                @foreach ($player['players'] as $playerDetail)
                <tr>
                    <td>{{ $playerDetail['Team'] }}</td>
                    <td>{{ $playerDetail['PrimaryPosition'] }}</td>
                    <td>{{ $playerDetail['SecondaryPosition'] }}</td>
                </tr>
                @endforeach
            </table>

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
    <div class="modal fade" id="editInfoModal" tabindex="-1" role="dialog" aria-labelledby="editInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInfoModalLabel">Edit Player Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-info-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="player_info_id" value="{{ $player['player_info']['PlayerInfo_ID'] }}">
                        
                        <div class="form-group">
                            <label for="player_email">Email Address</label>
                            <input type="email" class="form-control" name="player_email" value="{{ $player['player_info']['Player_Email'] }}" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="player_name">Name</label>
                            <input type="text" class="form-control" name="player_name" value="{{ $player['player_info']['Player_Name'] }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="current_password">Enter Your Password</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">Enter A New Password</label>
                            <input type="password" class="form-control" name="new_password">
                        </div>
                        
                        <div class="form-group">
                            <label for="player_image">Update Player Image</label>
                            <input type="file" class="form-control" name="player_image" id="player_image" accept="image/*">
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn-custom">Update Information</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editInfoForm = document.getElementById('edit-info-form');

            editInfoForm.onsubmit = function (event) {
                event.preventDefault();

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

                fetch(`http://127.0.0.1:8000/api/playersinfo/update-credentials/${playerId}`, {
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
                        location.reload();
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

    </script>

</body>
</html>
@endsection
