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
    }
    .fixed-top-right {
      position: fixed;
      top: 1rem;
      right: 1rem;
    }
  </style>
</head>
<body class="flex items-center justify-center bg-green-700">
  <div class="w-full max-w-sm mx-auto bg-green-600 rounded-lg p-8">
    <h1 class="text-white text-3xl font-bold mb-2">Welcome</h1>
    <p class="text-green-200 text-sm mb-8">Login to your account</p>
    <form action="{{ route('login.post') }}" method="POST">
      @csrf <!-- This directive generates the CSRF token input -->
      <div class="mb-4">
        <label class="block text-green-200 text-sm mb-2" for="email">Email</label>
        <div class="flex items-center bg-green-300 rounded-full px-4 py-2">
          <input type="email" id="email" name="Player_Email" class="bg-transparent flex-1 ml-2 outline-none" placeholder="Email" required>
        </div>
      </div>
      <div class="mb-6">
        <label class="block text-green-200 text-sm mb-2" for="password">Password</label>
        <div class="flex items-center bg-green-300 rounded-full px-4 py-2">
          <input type="password" id="password" name="Player_Password" class="bg-transparent flex-1 ml-2 outline-none" placeholder="Password" required>
        </div>
      </div>
      <div class="flex items-center justify-between mb-6">
        <label class="inline-flex items-center text-green-200 text-sm">
          <input type="checkbox" class="form-checkbox text-green-500">
          <span class="ml-2">Remember me</span>
        </label>
        <a href="{{ route('forgot_password.show') }}" class="text-sm text-green-200 hover:underline">Forgot Password?</a>
      </div>
      <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-full transition-colors">Login</button>
    </form>
    <p class="text-center text-green-200 text-sm mt-4">
      Haven't had an Account? <a href="{{ route('register.form') }}" class="text-white text-sm text-green-200 hover:underline">Sign Up</a>
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
