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
        $playerInfoId = session('playerInfoId');
        $playerName = $request->input('player_name');
        $newPassword = $request->input('new_password');
        $currentPassword = $request->input('current_password');
        $endpoint = "http://143.198.209.104/api/playersinfo/update-credentials/{$playerInfoId}";
        // dump($playerName);
        // dump($currentPassword);
        // dump($newPassword);
        try {
            $response = Http::asForm()->put($endpoint, [
                '_method' => 'PUT',
                'Player_Name' => $playerName,
                'current_password' => $currentPassword,
                'new_password' => $newPassword,
            ]);
            if ($response->status() === 200) {
                $redirectData = ['success' => 'Player information updated successfully.'];
                if (!empty($newPassword)) {
                    $redirectData = [
                        'success' => 'Password updated successfully. Redirecting to login page...',
                        'isRedirectToLogin' => true
                    ];
                }
                return redirect()->back()->with($redirectData);
                // return redirect()->back()->with('success', 'Player information updated successfully.');
            } else {
                return redirect()->back()->with('error', $response->json()['message']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
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

            //dd($data);

            // Validate the response structure
            if (isset($data['PlayerInfo_ID'], $data['Player_Name'], $data['Data']) && is_array($data['Data'])) {
                // Allow login even if AccountStatus_ID is null
                $accountStatusId = $data['AccountStatus_ID'] ?? 2; // Assuming 2 means 'not subscribed' when null

                // Pass the data to the view
                return view('home', [
                    'playerInfoId' => $data['PlayerInfo_ID'],
                    'playerName' => $data['Player_Name'],
                    'playerData' => $data['Data'],
                    'accountStatusId' => $accountStatusId, // Pass the AccountStatus_ID (null is handled as 'not subscribed')
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

        $playerInfoId = $request->input('player_info_id');
        $image = $request->file('player_image');

        // Get the file content
        $imageContent = fopen($image->getPathname(), 'r');

        // Make a POST request to the API to update the player's image
        $response = Http::attach('PlayerInfo_Image', $imageContent, $image->getClientOriginalName())
            ->post("http://143.198.209.104/api/playersinfo/update/{$playerInfoId}");

        // Check if the upload was successful
        if ($response->successful()) {
            $responseBody = $response->json();

            // Save the image URL in the session or any other necessary actions
            session(['Player_Image' => $responseBody['image_url']]);

            return redirect()->back()->with('success', 'Image uploaded successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to upload image']);
        }
    }

    public function createSubscription(Request $request)
{
    // Log the button click
    Log::info('Subscription button clicked');

    // Retrieve Player Info ID from session
    $playerInfoId = session('playerInfoId');
    Log::info('Player Info ID: ' . $playerInfoId);

    // Validate that the 'plan' input is provided
    $request->validate([
        'plan' => 'required|in:monthly,yearly', // Ensure the plan is either monthly or yearly
    ]);

    // Get the selected plan from the request
    $plan = $request->input('plan');
    Log::info('Subscription plan: ' . $plan); // Log the selected plan

    // Define the API endpoint for creating a subscription
    $endpoint = "http://143.198.209.104/api/create-checkout-session";

    try {
        // Make the POST request to the API
        $response = Http::post($endpoint, [
            'PlayerInfo_ID' => $playerInfoId, // Send Player Info ID
            'plan' => $plan, // Send selected plan
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            $responseData = $response->json(); // Get the JSON response data

            // Check if the checkout URL is present in the response
            if (isset($responseData['checkout_url'])) {
                Log::info('Redirecting to checkout URL: ' . $responseData['checkout_url']);

                // Use JavaScript to open the URL in a new tab
                return response()->json(['checkout_url' => $responseData['checkout_url']]); // Return the checkout URL in JSON
            } else {
                Log::error('Checkout URL not found.');
                return redirect()->back()->with('error', 'Failed to generate subscription URL.'); // Error handling
            }
        } else {
            Log::error('Failed to create subscription. Status: ' . $response->status());
            return redirect()->back()->with('error', 'Failed to create subscription.'); // Error handling
        }
    } catch (\Exception $e) {
        // Handle any exceptions and log the error
        Log::error('Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An unexpected error occurred.'); // Error handling
    }
}

public function showSubscriptionModal()
{
    // Retrieve PlayerInfo_ID from the session
    $playerInfoId = session('playerInfoId');

    // Make a GET request to the subscription status API endpoint
    $response = Http::get("http://143.198.209.104/api/player/subscription/{$playerInfoId}");

    // Check if the request was successful
    if ($response->successful()) {
        // Get the subscription data from the response
        $subscriptionData = $response->json();

        // Check if Plan and Next_Payment_Date exist in the response
        if (isset($subscriptionData['Plan']) && isset($subscriptionData['Next_Payment_Date'])) {
            // Return the subscription data as JSON
            return response()->json([
                'plan' => $subscriptionData['Plan'],
                'nextPaymentDate' => $subscriptionData['Next_Payment_Date'],
            ]);
        } else {
            // Handle the case where no subscription is found
            return response()->json(['error' => 'No subscription found'], 404); // Return a 404 error
        }
    } else {
        // Simply return a 500 error without any message
        return response()->json(['error' => 'Failed to retrieve subscription data'], 500);
    }
}




public function cancelSubscription()
    {
        // Retrieve PlayerInfo_ID from the session
        $playerInfoId = session('playerInfoId');

        // Make a POST request to the cancel subscription API endpoint
        $response = Http::post("http://143.198.209.104/api/payment/cancel", [
            'PlayerInfo_ID' => $playerInfoId
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            // Get the response message
            $responseData = $response->json();

            // Return success message
            return response()->json([
                'message' => $responseData['message'],
                'playerInfoId' => $responseData['PlayerInfo_ID']
            ]);
        } else {
            // Handle the error if the request failed
            return response()->json(['error' => 'Failed to cancel subscription'], $response->status());
        }
    }

}
