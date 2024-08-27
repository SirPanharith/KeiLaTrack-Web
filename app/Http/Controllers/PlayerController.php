<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class PlayerController extends Controller
{
    public function getPlayerInfo()
    {
        // Retrieve PlayerInfo_ID from the session
        $playerInfoId = session('playerInfoId');

        // Make a GET request to the API endpoint
        $response = Http::get('http://143.198.209.104/api/playersinfo/' . $playerInfoId);

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

        $response = Http::put('http://143.198.209.104/api/playersinfo/' . $playerInfoId, [
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
    // Retrieve the playerInfoId from session
    $playerInfoId = session('playerInfoId');

    // Check if playerInfoId is retrieved correctly from the session
    if (!$playerInfoId) {
        \Log::error('PlayerInfoId not found in session');
        return redirect()->route('login.show')->withErrors(['message' => 'Session expired or invalid. Please log in again.']);
    }

    \Log::info('PlayerInfoId retrieved from session', ['playerInfoId' => $playerInfoId]);

    try {
        // Make the API request
        $response = Http::get("http://143.198.209.104/api/session-info-by-playerinfo/{$playerInfoId}");

        if ($response->successful()) {
            $data = $response->json();

            // Log the response data for debugging
            \Log::info('API Response Data:', $data);

            // Validate the response structure
            if (isset($data['PlayerInfo_ID'], $data['Player_Name'], $data['Data']) && is_array($data['Data'])) {
                // Pass the data to the view
                return view('home', [
                    'playerInfoId' => $data['PlayerInfo_ID'],
                    'playerName' => $data['Player_Name'],
                    'playerData' => $data['Data'],
                ]);
            } else {
                \Log::warning('Unexpected API response structure', $data);
                return redirect()->back()->withErrors(['message' => 'Unexpected response from the server. Please try again later.']);
            }
        } else {
            \Log::error('Failed to fetch data from the API', ['status' => $response->status()]);
            return redirect()->back()->withErrors(['message' => 'Unable to retrieve session data. Please try again later.']);
        }
    } catch (\Exception $e) {
        \Log::error('Error occurred while fetching data from the API', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors(['message' => 'An unexpected error occurred. Please try again later.']);
    }
}



    public function show()
    {
        // Fetch player information using $playerInfoId and pass it to the view
        

        return view('player.information', compact('player'));
    }

    public function uploadPlayerImage(Request $request)
{
    
    $request->validate([
        'player_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // $playerInfoId = $request->input('player_info_id');
    // $image = $request->file('player_image');

    // // Assuming you have set up file storage properly
    // $path = $image->store('player_images', 'public');

    // // Update the player's image URL in the database
    // $player = Player::find($playerInfoId);
    // $player->PlayerInfo_Image = $path;
    // $player->save();

    $response = Http::attach(
        'PlayerInfo_Image',
        file_get_contents($request->file('player_image')->getPathname()),
        $request->file('player_image')->getClientOriginalName()
    )->post('http://143.198.209.104/api/playersinfo/update/3');

    // Check if the upload was successful
    if ($response->successful()) {
        $responseBody = $response->json();
        session([
            'Player_Image' => $responseBody['image_url']
        ]);
        
        return redirect()->back()->with('success', 'Image uploaded successfully');
    } else {
        return redirect()->back()->withErrors(['error' => 'Failed to upload image']);
    }

    // Return a response with the image URL
    // return response()->json([
    //     'success' => true,
    //     'message' => 'Player image updated successfully',
    //     'image_url' => asset('storage/' . $path)
    // ]);
}


}


