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
                <!-- <strong>Player Info ID:</strong> {{ $playerInfoId }}<br>
                <strong>Player Name:</strong> {{ $playerName }} -->
            </div>
            @foreach ($playerData as $player)
                @if (!empty($player['Sessions']))
                    <div class="team-summary">
                        <h3>Team Name: {{ $player['Team_Name'] }}</h3>
                        
                            @foreach ($player['Sessions'] as $session)
                                <li>
                                    <a style="text-decoration: none; color: white;" 
                                       href="{{ route('sessionhistory', ['sessionId' => $session['Session_ID'], 'playerId' => $player['Player_ID']]) }}">
                                       {{ $session['Session_Date']  }} - {{ $player['Team_Name'] }}
                                    </a>
                                </li>
                            @endforeach
                        
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</body>
</html>

@endsection
