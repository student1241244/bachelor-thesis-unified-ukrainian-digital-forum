@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Handle other flash messages like errors --}}

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <!-- User Registration Toggle -->
    <div>
        <label for="user_registration_enabled">User Registration Enabled:</label>
        <input type="checkbox" name="user_registration_enabled" {{ $settings['user_registration_enabled'] == 'on' ? 'checked' : '' }}>
    </div>

    <!-- Content Creation Toggle -->
    <div>
        <label for="content_creation_enabled">Content Creation Enabled:</label>
        <input type="checkbox" name="content_creation_enabled" {{ $settings['content_creation_enabled'] == 'on' ? 'checked' : '' }}>
    </div>

    <button type="submit">Save Settings</button>
</form>
