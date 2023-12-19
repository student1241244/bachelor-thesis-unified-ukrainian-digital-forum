<?php
declare( strict_types = 1 );

namespace Packages\Settings\App\Services\Crud;

use App\Mail\SettingsMail;
use Illuminate\Support\Facades\Mail;
use Packages\Settings\App\Models\Settings;

/**
 * Class SettingsCrudService
 */
class SettingsCrudService
{
    public function store(array $data): Settings
    {
        $Settings = Settings::create($data);

        Mail::to($settings->user->email)->send(new SettingsMail($settings));

        return $settings;
    }

    public function update(Settings $settings, array $data): Settings
    {
        $settings->update($data);

        return $settings;
    }

    public function delete(Settings $settings): void
    {
        $settings->delete($settings);
    }
}
