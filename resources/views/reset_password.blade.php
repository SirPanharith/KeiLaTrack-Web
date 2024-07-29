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
    <h1 class="text-white text-3xl font-bold mb-2">Reset Password</h1>
    <p class="text-green-200 text-sm mb-8">Enter your new password</p>
    <form action="{{ route('password.reset.post') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label class="block text-green-200 text-sm mb-2" for="password">New Password</label>
        <div class="flex items-center bg-green-300 rounded-full px-4 py-2">
          <input type="password" id="password" name="password" class="bg-transparent flex-1 ml-2 outline-none" placeholder="New Password" required>
        </div>
      </div>
      <div class="mb-4">
        <label class="block text-green-200 text-sm mb-2" for="password_confirmation">Confirm Password</label>
        <div class="flex items-center bg-green-300 rounded-full px-4 py-2">
          <input type="password" id="password_confirmation" name="password_confirmation" class="bg-transparent flex-1 ml-2 outline-none" placeholder="Confirm Password" required>
        </div>
      </div>
      <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-full transition-colors">Reset Password</button>
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
