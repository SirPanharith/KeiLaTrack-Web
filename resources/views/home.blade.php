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
</body>
</html>

@endsection
