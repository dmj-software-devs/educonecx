<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    /**
     * Show settings page.
     */
    public function index()
    {
        $settings = [
            'site_name' => config('app.name'),
            'site_email' => config('mail.from.address'),
            'currency' => config('app.currency', 'USD'),
            'currency_symbol' => config('app.currency_symbol', '$'),
            'stripe_key' => config('services.stripe.key'),
            'stripe_secret' => config('services.stripe.secret'),
            'paypal_client_id' => config('services.paypal.client_id'),
            'paypal_secret' => config('services.paypal.secret'),
            'mail_host' => config('mail.mailers.smtp.host'),
            'mail_port' => config('mail.mailers.smtp.port'),
            'mail_username' => config('mail.mailers.smtp.username'),
            'mail_encryption' => config('mail.mailers.smtp.encryption'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|max:255',
            'site_email' => 'required|email',
            'currency' => 'required|max:3',
            'currency_symbol' => 'required|max:5',
            'stripe_key' => 'nullable',
            'stripe_secret' => 'nullable',
            'paypal_client_id' => 'nullable',
            'paypal_secret' => 'nullable',
            'mail_host' => 'nullable',
            'mail_port' => 'nullable|numeric',
            'mail_username' => 'nullable',
            'mail_password' => 'nullable',
            'mail_encryption' => 'nullable|in:tls,ssl',
        ]);

        // Update .env file
        $this->updateEnvironmentVariable('APP_NAME', $request->site_name);
        $this->updateEnvironmentVariable('MAIL_FROM_ADDRESS', $request->site_email);
        $this->updateEnvironmentVariable('MAIL_FROM_NAME', $request->site_name);
        $this->updateEnvironmentVariable('APP_CURRENCY', $request->currency);
        $this->updateEnvironmentVariable('APP_CURRENCY_SYMBOL', $request->currency_symbol);
        $this->updateEnvironmentVariable('STRIPE_KEY', $request->stripe_key);
        $this->updateEnvironmentVariable('STRIPE_SECRET', $request->stripe_secret);
        $this->updateEnvironmentVariable('PAYPAL_CLIENT_ID', $request->paypal_client_id);
        $this->updateEnvironmentVariable('PAYPAL_SECRET', $request->paypal_secret);
        $this->updateEnvironmentVariable('MAIL_HOST', $request->mail_host);
        $this->updateEnvironmentVariable('MAIL_PORT', $request->mail_port);
        $this->updateEnvironmentVariable('MAIL_USERNAME', $request->mail_username);
        $this->updateEnvironmentVariable('MAIL_PASSWORD', $request->mail_password);
        $this->updateEnvironmentVariable('MAIL_ENCRYPTION', $request->mail_encryption);

        // Clear config cache
        Artisan::call('config:clear');

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Update environment variable.
     */
    private function updateEnvironmentVariable($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $oldValue = env($key);
            
            if ($oldValue !== $value) {
                if (strpos(file_get_contents($path), "{$key}=") !== false) {
                    // Update existing variable
                    file_put_contents($path, preg_replace(
                        "/{$key}=.*/",
                        "{$key}=" . ($value ?? ''),
                        file_get_contents($path)
                    ));
                } else {
                    // Add new variable
                    file_put_contents($path, PHP_EOL . "{$key}=" . ($value ?? ''), FILE_APPEND);
                }
            }
        }
    }
}