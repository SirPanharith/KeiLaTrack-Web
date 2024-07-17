<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlayerController extends Controller
{
    public function getPlayerInfo()
    {
        // Retrieve PlayerInfo_ID from the session
        $playerInfoId = session('PlayerInfo_ID');

        // Make a GET request to the API endpoint
        $response = Http::get('http://127.0.0.1:8000/api/players/' . $playerInfoId);

        // Check if the request was successful
        if ($response->successful()) {
            // Get the player data from the response
            $playerData = $response->json();
            // Pass the player data to the view
            return view('player_information', ['player' => $playerData]);
        } else {
            // If the request was not successful, return an error response
            return response()->json(['error' => 'Failed to retrieve player data from the API'], $response->status());
        }
    }

    public function updatePlayerInfo(Request $request)
    {
        $playerInfoId = $request->input('player_info_id');
        $playerName = $request->input('player_name');
        $playerEmail = $request->input('player_email');
        $playerPassword = $request->input('player_password');

        $response = Http::put('http://127.0.0.1:8000/api/playersinfo/' . $playerInfoId, [
            'PlayerInfo_ID' => $playerInfoId,
            'Player_Name' => $playerName,
            'Player_Email' => $playerEmail,
            'Player_Password' => $playerPassword,
        ]);

        if ($response->successful()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], $response->status());
        }
    }

    

    public function showPlayerSessions()
{
    $playerInfoId = session('playerInfoId');

    // Check if PlayerInfoId is retrieved correctly from session
    if (!$playerInfoId) {
        \Log::error('PlayerInfoId not found in session');
        return redirect()->route('login.show')->withErrors(['message' => 'Session expired or invalid. Please log in again.']);
    }

    \Log::info('PlayerInfoId from session: ', ['playerInfoId' => $playerInfoId]);

    // Fetch data from the API endpoint
    $response = Http::get("http://127.0.0.1:8000/api/session-info-by-playerinfo/{$playerInfoId}");

    if ($response->successful()) {
        $data = $response->json();

        // Log data for debugging
        \Log::info('API Response Data: ', $data);

        // dd($data);

        // Ensure the data format is correct and contains expected keys
        if (isset($data['PlayerInfo_ID'], $data['Player_Name'], $data['Data'])) {
            // Return the view with the fetched data
            return view('home', [
                'playerInfoId' => $data['PlayerInfo_ID'],
                'playerName' => $data['Player_Name'],
                'playerData' => $data['Data'],
            ]);
        } 

    }

    dd($response->json());

    // Handle the case where the API request fails
    \Log::error('Failed to fetch data from the API', ['status' => $response->status()]);
    return response()->json(['error' => 'Failed to fetch data from the API'], 500);
}


    public function show()
    {
        // Fetch player information using $playerInfoId and pass it to the view
        

        return view('player.information', compact('player'));
    }

}


