@extends('layouts.admin')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <h5>General Settings</h5>
        <hr>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Site Name</label>
                <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Site Email</label>
                <input type="email" name="site_email" class="form-control" value="{{ $settings['site_email'] }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Currency</label>
                <input type="text" name="currency" class="form-control" value="{{ $settings['currency'] }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Currency Symbol</label>
                <input type="text" name="currency_symbol" class="form-control" value="{{ $settings['currency_symbol'] }}" required>
            </div>
        </div>
        
        <h5 class="mt-4">Payment Settings</h5>
        <hr>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Stripe Key</label>
                <input type="text" name="stripe_key" class="form-control" value="{{ $settings['stripe_key'] }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Stripe Secret</label>
                <input type="text" name="stripe_secret" class="form-control" value="{{ $settings['stripe_secret'] }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">PayPal Client ID</label>
                <input type="text" name="paypal_client_id" class="form-control" value="{{ $settings['paypal_client_id'] }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">PayPal Secret</label>
                <input type="text" name="paypal_secret" class="form-control" value="{{ $settings['paypal_secret'] }}">
            </div>
        </div>
        
        <h5 class="mt-4">Mail Settings</h5>
        <hr>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Mail Host</label>
                <input type="text" name="mail_host" class="form-control" value="{{ $settings['mail_host'] }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Mail Port</label>
                <input type="text" name="mail_port" class="form-control" value="{{ $settings['mail_port'] }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Mail Username</label>
                <input type="text" name="mail_username" class="form-control" value="{{ $settings['mail_username'] }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Mail Password</label>
                <input type="password" name="mail_password" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Mail Encryption</label>
                <select name="mail_encryption" class="form-control">
                    <option value="">None</option>
                    <option value="tls" {{ $settings['mail_encryption'] == 'tls' ? 'selected' : '' }}>TLS</option>
                    <option value="ssl" {{ $settings['mail_encryption'] == 'ssl' ? 'selected' : '' }}>SSL</option>
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
    </form>
</div>
@endsection