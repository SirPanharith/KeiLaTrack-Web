<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="bg-green-300 dark:bg-zinc-800 min-h-screen flex items-center justify-center">
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl text-center mb-4">Welcome! Sign Up</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="Player_Name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Username</label>
                    <input type="text" id="Player_Name" name="Player_Name" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label for="Player_Email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email</label>
                    <input type="email" id="Player_Email" name="Player_Email" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label for="Player_Password" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Password</label>
                    <input type="password" id="Player_Password" name="Player_Password" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 dark:bg-zinc-800 dark:text-white">
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md w-full">Sign Up</button>
            </form>
            <p class="text-center mt-4">Already have an account? <a href="/login" class="text-green-500 hover:underline">Sign In</a></p>
        </div>
    </div>
</body>

</html>
