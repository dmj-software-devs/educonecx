@extends('layouts.main')
@section('title', 'Confirm Delivery')
@section('content')
<div class="container py-5">
    @include('partials.flash')
    <h1>Confirm Delivery</h1>
    <form method="POST" action="{{ route('client.requests.confirm.submit', $request) }}" class="card p-4">
        @csrf
        <div class="mb-3">
            <label class="form-label">Recipient Name</label>
            <input name="recipient_name" class="form-control @error('recipient_name') is-invalid @enderror" value="{{ old('recipient_name', auth()->user()->name) }}" required maxlength="200">
            @error('recipient_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Delivery Notes (optional)</label>
            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="4">{{ old('notes') }}</textarea>
            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <input type="hidden" name="signature" value="{{ old('signature') }}">
        <button class="btn btn-primary" type="submit">Confirm Delivery</button>
    </form>
</div>
@endsection
