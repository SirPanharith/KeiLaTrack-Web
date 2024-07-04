<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    } 

    public function showRegisterForm()
    {
        return view('signup');
    } 

    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'Player_Email' => 'required|email',
            'Player_Password' => 'required|string',
        ]);

        // Making a POST request to the backend login API
        $response = Http::post('http://127.0.0.1:8000/api/playersinfo/login', [
            'Player_Email' => $request->input('Player_Email'),
            'Player_Password' => $request->input('Player_Password'),
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();

            // Check if both 'player' and 'token' keys exist in the response data
            if (isset($data['player']) && isset($data['token'])) {
                // Store the player information and token in the session
                session([
                    'PlayerInfo_ID' => $data['player']['PlayerInfo_ID'],
                    'Player_Name' => $data['player']['Player_Name'],
                    'Player_Email' => $data['player']['Player_Email'],
                    'Player_Image' => $data['player']['PlayerInfo_Image'],
                    'token' => $data['token']
                ]);

                // Redirect to the dashboard with a success message
                return redirect('/')->with('success', 'Login successful');
            } else {
                // If the expected data is not present in the response, redirect back with an error message
                return redirect()->back()->withErrors(['login' => 'Invalid login response']);
            }
        } else {
            // If the response indicates failure
            $data = $response->json();

            // Handle specific error messages
            if (isset($data['message'])) {
                if ($data['message'] === 'Invalid email or password') {
                    // Invalid credentials
                    return redirect()->back()->withErrors(['login' => 'Invalid credentials']);
                } elseif ($data['message'] === 'Your daycare is inactive') {
                    // Daycare is inactive
                    return redirect()->back()->withErrors(['login' => 'Your daycare is inactive']);
                }
            }

            // Other error
            return redirect()->back()->withErrors(['login' => 'An error occurred']);
        }
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
        $response = Http::post('http://127.0.0.1:8000/api/playersinfo/register', [
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
    

    public function logout()
    {
        Auth::logout();
        session()->forget(['token',]);
        return redirect('/login')->with('success', 'Logout successful');
    }
}
