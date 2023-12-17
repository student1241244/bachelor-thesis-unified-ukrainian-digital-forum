<head>
    <style>
        .dot-red {
    width: 15px;
    height: 15px;
    background-color: red;
    border-radius: 50%;
    display: inline-block;
    margin-right: 10px;
}

.dot-green {
    width: 15px;
    height: 15px;
    background-color: green;
    border-radius: 50%;
    display: inline-block;
    margin-right: 10px;
}

    </style>
</head>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <h1>System Diagnostics</h1>

    <ul>
        @foreach ($results as $key => $result)
            <li>{{ ucfirst($key) }}:
                @if ($result == "Database connection is okay." || $result == "Stripe API is operational." || $result == "All composer dependencies are up to date.")
                    <div class="dot-green"></div>{{ $result }}</li>
                @else
                    <div class="dot-red"></div>{{ $result }}</li>
                @endif
        @endforeach
    </ul>

    <form action="{{ route('admin.toggleMaintenance') }}" method="POST">
        @csrf
    
        @if(app()->isDownForMaintenance())
            <button type="submit">Disable Maintenance Mode</button>
        @else
            <button type="submit">Enable Maintenance Mode</button>
        @endif
    </form>

    <form action="{{ route('admin.settings.updateBackupFrequency') }}" method="POST">
        @csrf
        <!-- Backup Frequency Setting -->
        <div>
            <label for="backup_frequency">Backup Frequency:</label>
            <select name="backup_frequency" id="backup_frequency">
                <option value="daily" {{ $frequency == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ $frequency == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="everyMinute" {{ $frequency == 'everyMinute' ? 'selected' : '' }}>Every Minute</option>
            </select>
        </div>
        <button type="submit">Save Changes</button>
    </form>
    