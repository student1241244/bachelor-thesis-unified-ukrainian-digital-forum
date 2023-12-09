<?php
declare( strict_types = 1 );

namespace Packages\Warnings\App\Services\Crud;

use App\Mail\WarningMail;
use Illuminate\Support\Facades\Mail;
use Packages\Warnings\App\Models\Warning;

/**
 * Class WarningCrudService
 */
class WarningCrudService
{
    public function store(array $data): Warning
    {
        $warning = Warning::create($data);

        Mail::to($warning->user->email)->send(new WarningMail($warning));

        return $warning;
    }

    public function update(Warning $warning, array $data): Warning
    {
        $warning->update($data);

        return $warning;
    }

    public function delete(Warning $warning): void
    {
        $warning->delete($warning);
    }
}
