@extends('layout.master')
@section('contents')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome back {{ $playerName }}!!!</h1>
        </div>
        <div class="performance-summary">
            <h2>Performance Summary:</h2>
            <div>
                <!-- Add any additional player information here if needed -->
            </div>
            @foreach ($playerData as $team)
                @if (!empty($team['Sessions']))
                    <div class="team-summary">
                        <h3>Team Name: {{ $team['Team_Name'] }}</h3>
                        <ul>
                            @foreach ($team['Sessions'] as $session)
                                <li>
                                    <a style="text-decoration: none; color: white;" 
                                       href="{{ route('sessionhistory', ['sessionId' => $session['Session_ID'], 'playerId' => $team['Player_ID']]) }}">
                                       {{ $session['Session_Date'] }} - {{ $team['Team_Name'] }}
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
