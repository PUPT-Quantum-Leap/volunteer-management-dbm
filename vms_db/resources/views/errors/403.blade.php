<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center p-8 bg-white rounded-lg shadow-lg max-w-md mx-4">
        <div class="text-6xl mb-4">🚫</div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">403 - Access Denied</h1>
        <p class="text-gray-600 mb-6">
            {{ $exception->getMessage() ?: 'You do not have permission to access this page.' }}
        </p>
        <div class="space-y-3">
            <a href="{{ url()->previous() }}" 
               class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition duration-200">
                ← Go Back
            </a>
            <a href="{{ url('/') }}" 
               class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">
                🏠 Go Home
            </a>
            @auth
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-2 px-4 rounded transition duration-200">
                        🔓 Logout & Login as Different User
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="block w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition duration-200">
                    🔐 Login
                </a>
            @endauth
        </div>
        
        <div class="mt-6 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-500">
                If you believe this is an error, please contact your administrator.
            </p>
        </div>
    </div>
</body>
</html>
