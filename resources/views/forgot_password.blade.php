<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
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
    <h1 class="text-white text-3xl font-bold mb-2">Forgot Password</h1>
    <p class="text-green-200 text-sm mb-8">Enter your email to receive an OTP</p>
    <form action="{{ route('forgot_password.post') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label class="block text-green-200 text-sm mb-2" for="email">Email</label>
        <div class="flex items-center bg-green-300 rounded-full px-4 py-2">
          <input type="email" id="email" name="email" class="bg-transparent flex-1 ml-2 outline-none" placeholder="Email" required>
        </div>
      </div>
      <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-full transition-colors">Send OTP</button>
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
