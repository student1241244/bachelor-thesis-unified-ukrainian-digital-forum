
<div class="row">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="ibox-content shadowed" style="margin-top: 20px;margin-left: 10px;">
<h2>Settings</h2>
<hr>
<h3>Content & Registration status:</h3>
<div style="margin: 10px;">
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

    <button type="submit" class="btn btn-xs btn-add">Save Settings</button>
</form>
</div>
<br>
<h2>Security Settings</h2>
<br>
<h3>Site Health:</h3>
<ul>
    @foreach ($results as $key => $result)
        <li>{{ ucfirst($key) }}:
            @if ($result == "Database connection is okay." || $result == "Stripe API is operational." || $result == "All composer dependencies are up to date.")
                <div style="width:10px;height:10px;background-color:green;border-radius:50%;display:inline-block;margin-right:10px;"></div>{{ $result }}</li>
            @else
                <div style="width:10px;height:10px;background-color:red;border-radius:50%;display:inline-block;margin-right:10px;"></div>{{ $result }}</li>
            @endif
    @endforeach
</ul>
<h3>Maintenance mode:</h3>
<div style="margin: 10px;">
<form action="{{ route('admin.toggleMaintenance') }}" method="POST">
    @csrf

    @if(app()->isDownForMaintenance())
        <button type="submit" class="btn btn-xs btn-add">Disable Maintenance Mode</button>
    @else
        <button type="submit" class="btn btn-xs btn-add">Enable Maintenance Mode</button>
    @endif
</form>
</div>
<h3>Backup frequency:</h3>
<div style="margin: 10px;">
<form action="{{ route('admin.settings.updateBackupFrequency') }}" method="POST">
    @csrf
    <!-- Backup Frequency Setting -->
        <label for="backup_frequency">Backup Frequency:</label>
        <select name="backup_frequency" id="backup_frequency">
            <option value="daily" {{ $frequency == 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="weekly" {{ $frequency == 'weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="everyMinute" {{ $frequency == 'everyMinute' ? 'selected' : '' }}>Every Minute</option>
        </select>
    <button type="submit" class="btn btn-xs btn-add">Save Changes</button>
</form>
</div>
<h3>Perfomance test:</h3>
<div style="margin: 10px;">
    <a class="btn btn-xs btn-add" href="{{ route('admin.settings.pagespeed') }}">Page Speed</a>
</div>
</div>