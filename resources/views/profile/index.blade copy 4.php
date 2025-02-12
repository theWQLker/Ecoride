<!-- Preferences Section -->
@if (Auth::user()->role !== 'admin')
<div class="mt-6 p-4 bg-gray-50 rounded-lg shadow">
    <h3 class="text-lg font-semibold mb-2">Preferences</h3>
    <form method="POST" action="{{ route('profile.updatePreferences') }}">
        @csrf
        
        <!-- Visible Preferences (2-3 per role) -->
        <div id="visible-preferences">
            @if (Auth::user()->role === 'driver')
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="no_smoking" {{ Auth::user()->no_smoking ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>No Smoking</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="pets_allowed" {{ Auth::user()->pets_allowed ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>Pets Allowed</span>
                </label>
            @else
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="enjoys_music" {{ Auth::user()->enjoys_music ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>Enjoys Music</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="prefers_female_driver" {{ Auth::user()->prefers_female_driver ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>Prefers Female Driver</span>
                </label>
            @endif
        </div>

        <!-- Dropdown for Extra Preferences -->
        <div class="mt-3">
            <button type="button" onclick="toggleDropdown()" class="bg-gray-300 px-3 py-2 rounded-lg">More Preferences</button>
            <div id="extra-preferences" class="hidden mt-3">
                @if (Auth::user()->role === 'driver')
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="accept_long_trips" {{ Auth::user()->accept_long_trips ? 'checked' : '' }} class="rounded border-gray-300">
                        <span>Accept Long Trips</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="car_type_preference" {{ Auth::user()->car_type_preference ? 'checked' : '' }} class="rounded border-gray-300">
                        <span>Car Type Preference</span>
                    </label>
                @else
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="no_smoking" {{ Auth::user()->no_smoking ? 'checked' : '' }} class="rounded border-gray-300">
                        <span>No Smoking</span>
                    </label>
                @endif
            </div>
        </div>

        <!-- Custom Preference Input -->
        <label class="flex items-center space-x-2 mt-4">
            <input type="text" name="custom_preference" placeholder="Add a custom preference..." class="rounded border-gray-300 px-3 py-1 w-full">
        </label>

        <button type="submit" class="mt-4 bg-black text-white px-4 py-2 rounded-lg">Save Preferences</button>
    </form>
</div>
@endif

<script>
function toggleDropdown() {
    document.getElementById('extra-preferences').classList.toggle('hidden');
}
</script>
