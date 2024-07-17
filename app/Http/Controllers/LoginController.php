<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
{
    // Validate input
    $request->validate([
        'Player_Email' => 'required|email',
        'Player_Password' => 'required'
    ]);

    // Make API request to login endpoint
    $response = Http::post('http://127.0.0.1:8000/api/playersinfo/login', [
        'Player_Email' => $request->input('Player_Email'),
        'Player_Password' => $request->input('Player_Password')
    ]);

    // Log response for debugging
    \Log::info('Login API Response: ', $response->json());

    // Check if the response is successful
    if ($response->successful()) {
        $data = $response->json();
        $player = $data['player'];
        $token = $data['token'];

        // Store player info and token in the session
        session([
            'playerInfoId' => $player['PlayerInfo_ID'],
            'playerName' => $player['Player_Name'],
            'playerToken' => $token,
            'Player_Image' => $player['PlayerInfo_Image']
        ]);

        // Log the session data
        \Log::info('Session Data: ', session()->all());

        // Redirect to home page
        return redirect()->route('home');
    } else {
        // Handle login failure
        return back()->withErrors(['loginError' => 'Invalid email or password.']);
    }
}

}
