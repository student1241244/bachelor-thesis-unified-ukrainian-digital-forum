<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DiagnosticService
{
    public function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return 'Database connection is okay.';
        } catch (\Exception $e) {
            return 'Failed to connect to database: ' . $e->getMessage();
        }
    }

    public function checkStripe()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            \Stripe\Account::retrieve();
            return 'Stripe API is operational.';
        } catch (\Exception $e) {
            return 'Failed to connect to Stripe API: ' . $e->getMessage();
        }
    }

    public function checkComposerDependencies()
    {
        $output = shell_exec('composer outdated --direct');
        return empty($output) ? 'All composer dependencies are up to date.' 
                              : 'Outdated composer dependencies: ' . $output;
    }    
}