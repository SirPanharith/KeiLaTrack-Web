<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    // public function showLoginForm()
    // {
    //     return view('login');
    // } 

    // public function login(Request $request)
    // {
    //     $client = new Client();
    //     $response = $client->post('http://127.0.0.1:8000/api/playersinfo/login', [
    //         'form_params' => [
    //             'Player_Email' => $request->input('Player_Email'),
    //             'Player_Password' => $request->input('Player_Password')
    //         ]
    //     ]);

    //     $data = json_decode($response->getBody(), true);

    //     if (isset($data['token'])) {
    //         // Save player info to session
    //         session([
    //             'PlayerInfo_ID' => $data['player']['PlayerInfo_ID'],
    //             'Player_Name' => $data['player']['Player_Name'],
    //             'Player_Email' => $data['player']['Player_Email'],
    //             'api_token' => $data['token']
    //         ]);

    //         // Redirect to the home route
    //         return redirect()->route('home');
    //     }

    //     // If login fails, redirect back with an error message
    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }

    public function logout(Request $request)
    {
        // Logout the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token to prevent CSRF attacks
        $request->session()->regenerateToken();

        // Clear all session data
        $request->session()->flush();

        // Redirect to login page with success message
        return redirect('/login')->with('success', 'Logout successful');
    }


    public function showRegisterForm()
    {
        return view('signup');
    }

    public function register(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'Player_Name' => 'required|string',
            'Player_Email' => 'required|email',
            'Player_Password' => 'required|string',
        ]);

        // Make a POST request to the registration endpoint
        $response = Http::post('http://143.198.209.104/api/playersinfo/register', [
            'Player_Name' => $request->input('Player_Name'),
            'Player_Email' => $request->input('Player_Email'),
            'Player_Password' => $request->input('Player_Password'),
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            // Redirect to the login page upon successful registration
            return redirect('/login')->with('success', 'Registration successful. Please log in.');
        } else {
            // If the response indicates failure
            $data = $response->json();

            // Handle specific error messages if any
            if (isset($data['message'])) {
                // If the registration failed due to some specific reason
                return redirect()->back()->withErrors(['registration' => $data['message']]);
            }

            // If there is no specific error message, redirect back with a general error message
            return redirect()->back()->withErrors(['registration' => 'An error occurred during registration']);
        }
    }
}
