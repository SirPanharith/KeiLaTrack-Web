@extends('layout.master')
@section('contents')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #4CAF50;
            font-size: 36px;
            margin: 0;
        }

        .performance-summary {
            padding: 20px;
            background-color: #4CAF50;
            border-radius: 8px;
            color: white;
            margin-bottom: 20px;
        }

        .performance-summary h2 {
            margin-top: 0;
            font-size: 24px;
        }

        .team-summary {
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .team-summary h3 {
            margin: 10px 0;
            color: #333;
            font-size: 20px;
        }

        .team-summary ul {
            list-style-type: none;
            padding: 0;
        }

        .team-summary li {
            margin: 5px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .team-summary li:hover {
            background-color: #f0f0f0;
        }

        .team-summary a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .team-summary a i {
            margin-right: 10px;
        }

        .team-summary a:hover {
            color: #333;
        }

        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 70px; /* Position below the navbar */
            width: 100%; /* Full width */
            height: calc(100% - 70px); /* Full height minus navbar height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 0 auto; /* Center horizontally */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            text-align: center;
            position: relative;
            top: 20%; /* Adjust as needed for vertical centering */
        }

        /* Disable pointer events on main contents when modal is shown */
        /* .locked {
            pointer-events: none; 
        } */

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome back {{ $playerName }}!!!</h1>
        </div>
        <div class="performance-summary">
            <h2><i class="fas fa-history"></i> Session History:</h2>
            @foreach ($playerData as $team)
                @if (!empty($team['Sessions']))
                    <?php
                        // Sort the sessions based on Session_Date and Session_Time in descending order
                        usort($team['Sessions'], function ($a, $b) {
                            // Compare dates first
                            $dateComparison = strcmp($b['Session_Date'], $a['Session_Date']);
                            if ($dateComparison === 0) {
                                // If dates are the same, compare times
                                return strcmp($b['Session_Time'], $a['Session_Time']);
                            }
                            return $dateComparison;
                        });
                    ?>
                    <div class="team-summary">
                    <h3 style="color: #4CAF50;"><i class="fas fa-users"></i> Team: {{ $team['Team_Name'] }} </h3>

    <h3 style="color: black; font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Games: {{ $team['Total_Games'] }} (Wins: {{ $team['Total_Wins'] }}, Losses: {{ $team['Total_Loses'] }}, Draws: {{ $team['Total_Draws'] }})</h3>

   
    

<table style="border: 2px solid #4CAF50; border-collapse: collapse; width: 100%; margin-top: 15px; text-align: center;">
    <tr>
    <td style="border-right: 2px solid white; border-top: 2px solid #4CAF50; border-bottom: 2px solid #4CAF50; padding: 8px; background-color: #4CAF50; color: white;"><strong>Total Goals for Team</strong></td>
    <td style="border-left: 2px solid white; border-right: 2px solid white; border-top: 2px solid #4CAF50; border-bottom: 2px solid #4CAF50; padding: 8px; background-color: #4CAF50; color: white;">
    <strong>Total Assists for Team</strong>
</td>

<td style="border: 2px solid #4CAF50; padding: 8px; background-color: #4CAF50; color: white;"><strong>Total Timeplayed for Team</strong></td>


    </tr>
    <tr>
        <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $team['Total_Goals_For_Team'] }}</td>
        <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $team['Total_Assists_For_Team'] }}</td>
        <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $team['Total_TimePlayed_For_Team'] }}</td>
    </tr>
</table>

<table style="border: 2px solid #4CAF50; border-collapse: collapse; width: 100%; margin-top: 15px; text-align: center;">
    <tr>
        <td style=" border-right: 2px solid white; border-top: 2px solid #4CAF50; border-bottom: 2px solid #4CAF50; padding: 8px; background-color: #4CAF50; color: white;"><strong>Primary Position</strong> </td>
        <td style="border-left: 2px solid white; border-top: 2px solid #4CAF50; border-bottom: 2px solid #4CAF50; padding: 8px; background-color: #4CAF50; color: white;"><strong>Secondary Position</strong> </td>
    </tr>
    <tr>
        <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $team['PrimaryPosition'] }}</td>
        <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $team['SecondaryPosition'] }}</td>
    </tr>
</table>



</p>

    <ul>
        @foreach ($team['Sessions'] as $session)
            <li>
                <a href="{{ route('sessionhistory', ['sessionId' => $session['Session_ID'], 'playerId' => $team['Player_ID']]) }}">
                   <i class="fas fa-calendar-alt"></i> {{ $session['Session_Date'] }} &nbsp; &nbsp;
                   <i class="fas fa-clock"></i> {{ $session['Session_Time'] }} &nbsp; &nbsp;
                   <i class="fas fa-clipboard"></i> {{ $team['Team_Name'] }} {{ $session['Session_Total_Goals'] }} - {{ $session['ManualAway_Score'] }} {{ $session['ManualAway_Name'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

                @endif
            @endforeach
        </div>
    </div>

    <!-- Subscription Modal -->
<div id="subscriptionModal" class="modal">
    <div class="modal-content">
        <h2 style="margin-bottom: 15px; color: #4CAF50">Subscription Required</h2>
        <p style="margin-bottom: 20px; font-size: 18px; line-height: 1.5;">
            Unlock exclusive features and elevate your experience with our subscription plans! 
            Choose what works best for you:
        </p>

        <form action="{{ route('create.subscription') }}" method="POST">
    @csrf
    <div class="button-container" style="margin: 20px 0;">
    <button type="button" id="monthlyPlanButton" style="background-color: #4CAF50; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
        $3 Monthly
    </button>
    <button type="button" id="yearlyPlanButton" style="background-color: #4CAF50; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
        $36 Yearly
    </button>
</div>

    </div>
    <p style="color: #555; text-align: center;">
        Enjoy a <strong>free 14-day trial</strong> with your first Subscription!
    </p>
</form>

    </div>
</div>

    <script>
        // Get the modal and main contents
        var modal = document.getElementById("subscriptionModal");
        var mainContents = document.getElementById("mainContents");

        // Check AccountStatus_ID and show modal if necessary
        var accountStatusId = @json($accountStatusId); // Ensure this value is fetched correctly

        // Only show the modal if the account status is 2 or null
        if (accountStatusId === 2 || accountStatusId === null) {
            modal.style.display = "block"; // Show the modal
            mainContents.classList.add("locked"); // Lock the content
        } else {
            modal.style.display = "none"; // Ensure the modal is hidden for subscribed users
            mainContents.classList.remove("locked"); // Unlock the content
        }

        // Prevent closing the modal by clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                // Do nothing, modal cannot be closed
            }
        }
    </script>

    <!-- JavaScript to handle the button click -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#monthlyPlanButton').addEventListener('click', function() {
    createSubscription('monthly');
});

document.querySelector('#yearlyPlanButton').addEventListener('click', function() {
    createSubscription('yearly');
});
document.querySelector('#monthlyPlanButton').addEventListener('click', function() {
    createSubscription('monthly');
});

document.querySelector('#yearlyPlanButton').addEventListener('click', function() {
    createSubscription('yearly');
});

function createSubscription(plan) {
    fetch('{{ route('create.subscription') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ plan: plan })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.checkout_url) {
            // Open the URL in a new tab
            window.open(data.checkout_url, '_blank');
        } else {
            alert('Failed to generate subscription URL.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred.');
    });
}

});


</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const monthlyPlanButton = document.getElementById('monthlyPlanButton');
    const yearlyPlanButton = document.getElementById('yearlyPlanButton');

    monthlyPlanButton.addEventListener('click', function () {
        createSubscription('monthly');
    });

    yearlyPlanButton.addEventListener('click', function () {
        createSubscription('yearly');
    });

    function createSubscription(plan) {
        fetch('{{ route('create.subscription') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
            },
            body: JSON.stringify({ plan: plan }) // Send the plan as JSON
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.checkout_url) {
                // Open the URL in a new tab
                window.open(data.checkout_url, '_blank');
            } else {
                alert('Failed to generate subscription URL.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred.');
        });
    }
});
</script>




</body>
</html>

@endsection
