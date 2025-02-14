<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Profile</h1>
        
        @if (session('status'))
            <div class="bg-green-500 text-white p-2 mb-4">
                {{ session('status') }}
            </div>
        @endif
        
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-semibold">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="border p-2 w-full">
            </div>
            
            <div>
                <label for="email" class="block font-semibold">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="border p-2 w-full">
            </div>
            
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Update Profile</button>
        </form>

        <h2 class="text-xl font-bold mt-6">Preferences</h2>
        <form action="{{ route('profile.updatePreferences') }}" method="POST" class="space-y-4 mt-4">
            @csrf
            @method('PUT')

            <div>
                <label for="no_smoking" class="block font-semibold">No Smoking</label>
                <input type="checkbox" name="no_smoking" id="no_smoking" value="1" {{ $preferences->no_smoking ? 'checked' : '' }}>
            </div>

            <div>
                <label for="pets_allowed" class="block font-semibold">Pets Allowed</label>
                <input type="checkbox" name="pets_allowed" id="pets_allowed" value="1" {{ $preferences->pets_allowed ? 'checked' : '' }}>
            </div>
            
            <button type="submit" class="bg-green-500 text-white px-4 py-2">Update Preferences</button>
        </form>
    </div>
</body>
</html>
