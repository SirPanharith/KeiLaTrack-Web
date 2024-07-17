@extends('layout.master')
@section('contents')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Information</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #e9e9e9;
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

        .profile-picture img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .container {
            background-color: #ffffff;
            color: #333;
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .player-info {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .player-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .info-table {
            margin: auto;
            width: 90%;
            border-collapse: collapse;
        }

        .info-table th, .info-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .info-table th {
            background-color: #4CAF50;
            color: white;
        }

        .info-table td {
            background-color: #fff;
            color: #333;
        }

        h1 {
            margin-bottom: 20px;
        }

        .edit-form {
            display: none;
            margin-top: 20px;
        }

        .edit-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        .edit-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .edit-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="player-info">
            <img src="{{ $player['player_info']['PlayerInfo_Image'] }}" alt="Player Image" class="player-image">
            <h1>Player Information:</h1>
            <table class="info-table">
                <tr>
                    <td><strong>Name:</strong></td>
                    <td>{{ $player['player_info']['Player_Name'] }}</td>
                </tr>
                <tr>
                    <td><strong>Email Address:</strong></td>
                    <td>{{ $player['player_info']['Player_Email'] }}</td>
                </tr>
                <!-- <tr>
                    <td><strong>Password:</strong></td>
                    <td><input type="password" value="{{ $player['player_info']['Player_Password'] }}" readonly></td>
                </tr> -->
            </table>
            <h2>Teams and Positions:</h2>
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
            <button id="edit-info-btn">Edit Information</button>
            <form id="edit-info-form" class="edit-form">
                @csrf
                <input type="hidden" name="player_info_id" value="{{ $player['player_info']['PlayerInfo_ID'] }}">
                <input type="text" name="player_name" value="{{ $player['player_info']['Player_Name'] }}" required>
                <input type="email" name="player_email" value="{{ $player['player_info']['Player_Email'] }}" required>
                <input type="password" name="player_password" value="{{ $player['player_info']['Player_Password'] }}" required>
                <button type="submit">Save Changes</button>
            </form>
        </div><br>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editInfoBtn = document.getElementById('edit-info-btn');
            var editInfoForm = document.getElementById('edit-info-form');

            editInfoBtn.onclick = function () {
                editInfoForm.style.display = 'block';
                editInfoBtn.style.display = 'none';
            };

            editInfoForm.onsubmit = function (event) {
                event.preventDefault();

                var formData = new FormData(editInfoForm);
                var playerId = formData.get('player_info_id');

                fetch(`http://127.0.0.1:8000/api/playersinfo/${playerId}`, {
                    method: 'PUT',
                    body: JSON.stringify({
                        PlayerInfo_ID: playerId,
                        Player_Name: formData.get('player_name'),
                        Player_Email: formData.get('player_email'),
                        Player_Password: formData.get('player_password'),
                    }),
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
                        alert('Failed to update information.');
                    }
                })
                .catch(error => {
                    console.error('Error updating information:', error);
                });

                editInfoForm.style.display = 'none';
                editInfoBtn.style.display = 'block';
            };
        });
    </script>
</body>
</html>
@endsection
