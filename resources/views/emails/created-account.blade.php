<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account Is Ready!</title>
</head>
<body class="bg-gray-50">
    <div class="max-w-2xl mx-auto p-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome, {{ $user->name }}!</h1>
            <p class="text-gray-600">Your account has been successfully created</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8 border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Login Details</h2>
            
            <div class="space-y-3 mb-6">
                <div class="flex">
                    <span class="w-24 font-medium text-gray-700">Email:</span>
                    <span class="text-gray-900">{{ $user->email }}</span>
                </div>
                <div class="flex">
                    <span class="w-24 font-medium text-gray-700">Password:</span>
                    <span class="text-gray-900">{{$user->password }}</span>
                </div>
            </div>

            <a href="https://isatuservice.space" class="inline-block w-full text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200">
                Login to Your Account
            </a>
        </div>

        <!-- Additional Info -->
        <div class="text-center text-sm text-gray-500 mb-6">
            <p>If you didn't request this account, please ignore this email.</p>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-400 border-t border-gray-200 pt-6">
            <p>© {{ date('Y') }} Your Company Name. All rights reserved.</p>
            <p class="mt-1">Need help? <a href="mailto:support@isatuservice.space" class="text-blue-500 hover:underline">Contact our support team</a></p>
        </div>
    </div>
</body>
</html>