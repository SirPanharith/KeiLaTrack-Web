<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class SessionGameDetailsController extends Controller
{
    public function getSessionGame($sessionId, $playerId)
    {
        // Make a GET request to the API endpoint
        $response = Http::get("http://127.0.0.1:8000/api/session-games/{$sessionId}/player/{$playerId}");

        // Check if request was successful
        if ($response->successful()) {
            // Parse the JSON response
            $sessionGame = $response->json();

            // Extract individual elements
            $sessionId = $sessionGame['Session_ID'];
            $sessionDate = $sessionGame['Session_Date'];
            $sessionTime = $sessionGame['Session_Time'];
            $sideId = $sessionGame['Side_ID'];
            $totalPlayerPerSide = $sessionGame['TotalPlayerPerSide'];
            $playerId = $sessionGame['Player_ID'];
            $playerName = $sessionGame['Player_Name'];
            $primaryPosition = $sessionGame['PrimaryPosition'];
            $secondaryPosition = $sessionGame['SecondaryPosition'];
            $totalGoals = $sessionGame['Total_Goals'];
            $totalAssists = $sessionGame['Total_Assists'];
            $sessionTotalGoals = $sessionGame['Session_Total_Goals'];
            $manualAwayName = $sessionGame['ManualAway_Name'];
            $manualAwayScore = $sessionGame['ManualAway_Score'];
            $teamName = $sessionGame['Team_Name'];
            $sessionLocation = $sessionGame['Session_Location'];
            $totalDuration = $sessionGame['Total_Duration'];

            // Fetch the player note
            $noteResponse = Http::get("http://127.0.0.1:8000/api/player-notes/{$sessionId}/{$playerId}");
            $playerNote = $noteResponse->successful() ? $noteResponse->json()['PlayerNote'] : '(Add your note)';

            // Return the view with individual elements
            return view('sessionhistory', compact(
                'sessionId', 'sessionDate', 'sessionTime', 'sideId', 'totalPlayerPerSide', 'playerId', 'playerName',
                'primaryPosition', 'secondaryPosition', 'totalGoals', 'totalAssists', 'sessionTotalGoals',
                'manualAwayName', 'manualAwayScore', 'teamName', 'sessionLocation', 'totalDuration', 'playerNote'
            ));
        } else {
            // Log the error response for debugging
            \Log::error('API Error Response:', ['response' => $response->body()]);

            // Return an error view if request was not successful
            return view('sessionhistory')->with('message', 'Failed to fetch session game details');
        }
    }

    public function savePlayerNote(Request $request)
    {
        $sessionId = $request->input('session_id');
        $playerId = $request->input('player_id');
        $playerNote = $request->input('player_note');

        // Fetch the existing player note to get its ID
        $noteResponse = Http::get("http://127.0.0.1:8000/api/player-notes/{$sessionId}/{$playerId}");

        if ($noteResponse->successful()) {
            $noteId = $noteResponse->json()['PlayerNote_ID'];

            // Update the existing player note
            $response = Http::put("http://127.0.0.1:8000/api/player-notes/{$noteId}", [
                'Session_ID' => $sessionId,
                'Player_ID' => $playerId,
                'PlayerNote' => $playerNote,
            ]);

            if ($response->successful()) {
                return response()->json(['message' => 'Note updated successfully']);
            } else {
                return response()->json(['message' => 'Failed to update note'], 500);
            }
        } else {
            // Handle the case where the note does not exist yet
            $response = Http::post('http://127.0.0.1:8000/api/player-notes', [
                'Session_ID' => $sessionId,
                'Player_ID' => $playerId,
                'PlayerNote' => $playerNote,
            ]);

            if ($response->successful()) {
                return response()->json(['message' => 'Note created successfully']);
            } else {
                return response()->json(['message' => 'Failed to create note'], 500);
            }
        }
    }

    public function createPlayerNote(Request $request)
    {
        $sessionId = $request->input('session_id');
        $playerId = $request->input('player_id');
        $playerNote = $request->input('player_note');

        // Create the player note
        $response = Http::post('http://127.0.0.1:8000/api/player-notes', [
            'Session_ID' => $sessionId,
            'Player_ID' => $playerId,
            'PlayerNote' => $playerNote,
        ]);

        if ($response->successful()) {
            return response()->json(['message' => 'Note created successfully']);
        } else {
            return response()->json(['message' => 'Failed to create note'], 500);
        }
    }

    // public function show()
    // {
    //     $playerInfoId = session('playerInfoId');

    //     // Debugging: Check if PlayerInfoId is retrieved correctly from session
    //     if (!$playerInfoId) {
    //         return redirect()->route('login.show')->withErrors(['message' => 'Session expired or invalid. Please log in again.']);
    //     }

    //     // Fetch data from the API endpoint
    //     $response = Http::get("http://127.0.0.1:8000/api/session-info-by-playerinfo/{$playerInfoId}");

    //     if ($response->successful()) {
    //         $data = $response->json();

    //         // Return the view with the fetched data
    //         return view('home', [
    //             'playerInfoId' => $data['PlayerInfo_ID'],
    //             'playerName' => $data['Player_Name'],
    //             'playerData' => $data['Data'],
    //         ]);
    //     }

    //     // Handle the case where the API request fails
    //     return response()->json(['error' => 'Failed to fetch data from the API'], 500);
    // }
    
}
