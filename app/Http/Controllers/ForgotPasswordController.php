<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;



class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('forgot_password');
    }

    public function sendOtp(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // Send the OTP to the email
    $response = Http::post('http://143.198.209.104/api/password/forgot', [
        'email' => $request->email,
    ]);

    if ($response->successful()) {
        // Store email in session
        session(['email' => $request->email]);
        return redirect()->route('otp.form')->with('success', 'OTP sent successfully to your email.');
    } else {
        return redirect()->back()->withErrors(['message' => 'Failed to send OTP. Please try again.']);
    }
}




public function showOtpForm()
{
    $email = session('email');
    if (!$email) {
        return redirect()->route('forgot_password.form')->withErrors(['message' => 'Invalid session. Please retry the process.']);
    }

    return view('otp', compact('email'));
}


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $email = Session::get('email');

        // Verify OTP
        $response = Http::post('http://143.198.209.104/api/password/reset', [
            'email' => $email,
            'otp' => $request->input('otp'),
        ]);

        if ($response->successful()) {
            return redirect()->route('password.reset.show')->with('success', 'OTP verified. Please reset your password.');
        } else {
            return redirect()->back()->withErrors(['message' => 'Invalid OTP.']);
        }
    }

    public function showResetPasswordForm()
    {
        return view('reset_password');
    }

    public function resetPassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Prepare the payload
        $payload = [
            'email' => $request->email,
            'otp' => $request->otp,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ];

        // Send a POST request to the API endpoint
        $response = Http::post('http://143.198.209.104/api/password/reset', $payload);

        if ($response->successful()) {
            // Clear the session after successful password reset
            $request->session()->forget(['otp', 'email']);
            return redirect()->route('login.show')->with('success', 'Password reset successful. You can now log in.');
        } else {
            return redirect()->back()->withErrors(['message' => 'Failed to reset password. Please try again.']);
        }
    }

}


