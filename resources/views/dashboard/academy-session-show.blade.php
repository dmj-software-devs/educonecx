@extends('layouts.main')

@section('title', 'Speaking Session Report')

@push('styles')
<style>
    .academy-detail-wrapper {
        max-width: 1100px;
        margin: 32px auto;
        padding: 0 20px;
    }

    .academy-detail-card {
        background: #fff;
        border: 1px solid rgba(251, 198, 12, 0.16);
        border-radius: 14px;
        box-shadow: 0 10px 24px rgba(10, 29, 68, 0.08);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .academy-detail-header {
        background: linear-gradient(135deg, #0A1D44, #18386E, #2E5C61);
        color: #FEFDFE;
        padding: 28px;
    }

    .academy-detail-header h1 {
        margin: 0 0 10px;
        font-size: 1.8rem;
        font-weight: 800;
    }

    .academy-detail-meta {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        color: #F9F7E9;
        font-size: 0.95rem;
    }

    .academy-detail-body {
        padding: 24px;
    }

    .academy-score-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 14px;
    }

    .academy-score-box {
        background: #F9F7E9;
        border: 1px solid rgba(10, 29, 68, 0.06);
        border-radius: 10px;
        padding: 16px;
    }

    .academy-score-box span {
        display: block;
        color: #6B7280;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 5px;
    }

    .academy-score-box strong {
        color: #0A1D44;
        font-size: 1.3rem;
    }

    .academy-section {
        margin-top: 24px;
    }

    .academy-section h2 {
        color: #0A1D44;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .academy-panel {
        background: #FEFDFE;
        border: 1px solid rgba(203, 209, 218, 0.7);
        border-radius: 10px;
        padding: 16px;
        color: #2E5C61;
    }

    .academy-list-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
    }

    .academy-correction-item {
        padding: 12px 0;
        border-bottom: 1px solid rgba(203, 209, 218, 0.7);
    }

    .academy-correction-item:last-child {
        border-bottom: 0;
    }

    .academy-back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        color: #18386E;
        font-weight: 700;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
@php
    $formatScore = fn ($score) => is_null($score) ? 'N/A' : number_format($score, 1) . '/10';
@endphp

<div class="academy-detail-wrapper">
    <a href="{{ route('dashboard') }}" class="academy-back-link">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <div class="academy-detail-card">
        <div class="academy-detail-header">
            <h1>{{ $session->scenario->title ?? 'EDUCONECX Daily Conversation' }}</h1>
            <div class="academy-detail-meta">
                <span><i class="fas fa-layer-group"></i> {{ $session->category->title ?? 'No category' }}</span>
                <span><i class="far fa-calendar-alt"></i> Created {{ optional($session->created_at)->format('M d, Y g:i A') }}</span>
                @if($session->started_at)
                    <span><i class="fas fa-play"></i> Started {{ $session->started_at->format('M d, Y g:i A') }}</span>
                @endif
                @if($session->evaluated_at)
                    <span><i class="fas fa-check-circle"></i> Evaluated {{ $session->evaluated_at->format('M d, Y g:i A') }}</span>
                @endif
                <span><i class="fas fa-info-circle"></i> {{ ucfirst($session->status ?? 'pending') }}</span>
            </div>
        </div>

        <div class="academy-detail-body">
            <div class="academy-score-grid">
                <div class="academy-score-box"><span>Overall</span><strong>{{ $formatScore($session->overall_score) }}</strong></div>
                <div class="academy-score-box"><span>Pronunciation</span><strong>{{ $formatScore($session->pronunciation_score) }}</strong></div>
                <div class="academy-score-box"><span>Grammar</span><strong>{{ $formatScore($session->grammar_score) }}</strong></div>
                <div class="academy-score-box"><span>Fluency</span><strong>{{ $formatScore($session->fluency_score) }}</strong></div>
                <div class="academy-score-box"><span>Vocabulary</span><strong>{{ $formatScore($session->vocabulary_score) }}</strong></div>
            </div>

            @if($audioUrl)
                <div class="academy-section">
                    <h2>Audio Recording</h2>
                    <div class="academy-panel">
                        <audio controls src="{{ $audioUrl }}" style="width: 100%;"></audio>
                    </div>
                </div>
            @endif

            <div class="academy-section">
                <h2>Transcript</h2>
                <div class="academy-panel">
                    {!! nl2br(e($session->transcript ?? 'No transcript saved yet.')) !!}
                </div>
            </div>

            <div class="academy-section">
                <h2>Feedback Report</h2>
                <div class="academy-panel">
                    {!! nl2br(e($session->feedback ?? 'No feedback saved yet.')) !!}
                </div>
            </div>

            <div class="academy-section academy-list-grid">
                <div>
                    <h2>Strengths</h2>
                    <div class="academy-panel">
                        @forelse(($session->strengths ?? []) as $strength)
                            <p class="mb-2"><i class="fas fa-check text-success"></i> {{ $strength }}</p>
                        @empty
                            <p class="mb-0">No strengths saved yet.</p>
                        @endforelse
                    </div>
                </div>
                <div>
                    <h2>Weaknesses</h2>
                    <div class="academy-panel">
                        @forelse(($session->weaknesses ?? []) as $weakness)
                            <p class="mb-2"><i class="fas fa-exclamation-circle text-warning"></i> {{ $weakness }}</p>
                        @empty
                            <p class="mb-0">No weaknesses saved yet.</p>
                        @endforelse
                    </div>
                </div>
                <div>
                    <h2>Next Steps</h2>
                    <div class="academy-panel">
                        @forelse(($session->next_steps ?? []) as $nextStep)
                            <p class="mb-2"><i class="fas fa-arrow-right"></i> {{ $nextStep }}</p>
                        @empty
                            <p class="mb-0">No next steps saved yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="academy-section">
                <h2>Corrections</h2>
                <div class="academy-panel">
                    @forelse(($session->corrections ?? []) as $correction)
                        <div class="academy-correction-item">
                            <p class="mb-1"><strong>Original:</strong> {{ data_get($correction, 'original') }}</p>
                            <p class="mb-1"><strong>Corrected:</strong> {{ data_get($correction, 'corrected') }}</p>
                            <p class="mb-0 text-muted">{{ data_get($correction, 'explanation') }}</p>
                        </div>
                    @empty
                        <p class="mb-0">No corrections saved yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
