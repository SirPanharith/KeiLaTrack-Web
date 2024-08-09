<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      background-color: #66bb6a; /* Lighter shade of green */
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .fixed-top-right {
      position: fixed;
      top: 1rem;
      right: 1rem;
    }
    .bg-custom-green {
      background-color: #4CAF50;
    }
    .input-group {
      background-color: rgba(255, 255, 255, 0.2);
      padding: 0.75rem 1rem;
      border-radius: 50px;
      transition: background-color 0.3s ease-in-out;
    }
    .input-group input {
      background-color: transparent;
      border: none;
      outline: none;
      color: white;
      width: 100%;
    }
    .input-group input::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }
    .input-group:hover {
      background-color: rgba(255, 255, 255, 0.3);
    }
    .login-button {
      background-color: #388E3C;
      padding: 0.75rem 1rem;
      border-radius: 50px;
      font-size: 1.1rem;
      transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
    }
    .login-button:hover {
      background-color: #2E7D32;
      transform: translateY(-3px);
    }
    .login-button:active {
      background-color: #1B5E20;
      transform: translateY(1px);
    }
    .login-box {
      border: 4px solid #ffffff; /* Thicker white border around the login box */
      padding: 2rem;
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <div class="w-full max-w-sm mx-auto bg-custom-green rounded-lg shadow-lg login-box">
    <h1 class="text-white text-4xl font-bold mb-2 text-center">KeiLaTrack</h1>
    <p class="text-white text-sm mb-8 text-center">Reset Password</p>
    <p class="text-white text-sm mb-8 text-center">An OTP has been sent to your email. Please enter the details below to reset your password.</p>

    <form action="{{ route('password.reset.post') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label class="block text-white text-sm mb-2" for="email">Email</label>
        <div class="input-group">
          <input type="email" id="email" name="email" class="flex-1" placeholder="Enter your email" required>
        </div>
      </div>
      <div class="mb-4">
        <label class="block text-white text-sm mb-2" for="otp">OTP</label>
        <div class="input-group">
          <input type="text" id="otp" name="otp" class="flex-1" placeholder="Enter OTP" required>
        </div>
      </div>
      <div class="mb-4">
        <label class="block text-white text-sm mb-2" for="password">New Password</label>
        <div class="input-group">
          <input type="password" id="password" name="password" class="flex-1" placeholder="New Password" required>
        </div>
      </div>
      <div class="mb-4">
        <label class="block text-white text-sm mb-2" for="password_confirmation">Confirm Password</label>
        <div class="input-group">
          <input type="password" id="password_confirmation" name="password_confirmation" class="flex-1" placeholder="Confirm Password" required>
        </div>
      </div>
      <button type="submit" class="w-full login-button text-white font-bold">Reset Password</button>
    </form>

    @if ($errors->any())
      <div id="errorAlert1" class="fixed-top-right bg-red-500 text-white p-4 rounded shadow-md">
        <ul class="mb-0 list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if (session('success'))
      <div id="successAlert1" class="fixed-top-right bg-green-500 text-white p-4 rounded shadow-md">
        <p>{{ session('success') }}</p>
      </div>
    @endif
  </div>

  <script>
    setTimeout(function() {
        var errorAlert = document.getElementById('errorAlert1');
        if (errorAlert) {
          errorAlert.remove();
        }
        var successAlert = document.getElementById('successAlert1');
        if (successAlert) {
          successAlert.remove();
        }
      }, 10000);
  </script>
</body>
</html>
