<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
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
        <p class="text-white text-sm mb-8 text-center">Sign Up for an Account</p>

        @if ($errors->any())
        <div id="errorAlert" class="fixed-top-right bg-red-500 text-white p-4 rounded shadow-md">
            <ul class="mb-0 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div id="successAlert" class="fixed-top-right bg-green-500 text-white p-4 rounded shadow-md">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-white text-sm mb-2" for="Player_Name">Username</label>
                <div class="input-group">
                    <input type="text" id="Player_Name" name="Player_Name" class="flex-1" placeholder="Username" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-white text-sm mb-2" for="Player_Email">Email</label>
                <div class="input-group">
                    <input type="email" id="Player_Email" name="Player_Email" class="flex-1" placeholder="Email" required>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-white text-sm mb-2" for="Player_Password">Password</label>
                <div class="input-group">
                    <input type="password" id="Player_Password" name="Player_Password" class="flex-1" placeholder="Password" required>
                </div>
            </div>
            <button type="submit" class="w-full login-button text-white font-bold">Sign Up</button>
        </form>
        <p class="text-center text-white text-sm mt-4">
            Already have an account? <a href="/login" class="text-white hover:underline">Sign In</a>
        </p>
    </div>

    <script>
        setTimeout(function() {
            var errorAlert = document.getElementById('errorAlert');
            if (errorAlert) {
                errorAlert.remove();
            }
            var successAlert = document.getElementById('successAlert');
            if (successAlert) {
                successAlert.remove();
            }
        }, 10000);
    </script>
</body>

</html>
