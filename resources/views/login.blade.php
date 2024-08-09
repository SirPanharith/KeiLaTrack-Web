<!-- login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form Component</title>
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
    <p class="text-white text-sm mb-8 text-center">Login to your account</p>
    <form action="{{ route('login.post') }}" method="POST">
      @csrf <!-- This directive generates the CSRF token input -->
      <div class="mb-4">
        <label class="block text-white text-sm mb-2" for="email">Email</label>
        <div class="input-group">
          <input type="email" id="email" name="Player_Email" class="flex-1" placeholder="Email" required>
        </div>
      </div>
      <div class="mb-6">
        <label class="block text-white text-sm mb-2" for="password">Password</label>
        <div class="input-group">
          <input type="password" id="password" name="Player_Password" class="flex-1" placeholder="Password" required>
        </div>
      </div>
      <div class="flex items-center justify-between mb-6">
        <a href="{{ route('forgot_password.show') }}" class="text-sm text-white hover:underline">Forgot Password?</a>
      </div>
      <button type="submit" class="w-full login-button text-white font-bold">Login</button>
    </form>
    <p class="text-center text-white text-sm mt-4">
      Haven't had an Account? <a href="{{ route('register.form') }}" class="text-white hover:underline">Sign Up</a>
    </p>
  </div>
  @if ($errors->any())
  <div id="errorAlert1" class="fixed-top-right bg-red-500 text-white p-4 rounded shadow-md">
    <ul class="mb-0 list-disc list-inside">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <script> 
  setTimeout(function() {
      var sucessAlert = document.getElementById('errorAlert1');
      if (sucessAlert) {
        sucessAlert.remove();
      }
    }, 10000);
  </script>
</body>
</html>
