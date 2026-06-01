@extends('layouts.main')

@section('title', 'Academy Session Details')

@push('styles')
<style>
    .academy-show-page { --navy:#0A1D44; --navy2:#18386E; --yellow:#FBC60C; --ivory:#F9F7E9; --border:rgba(10,29,68,.1); background:linear-gradient(135deg,var(--ivory),#fff); min-height:100vh; padding:28px; }
    .academy-show-wrap { max-width:1100px; margin:0 auto; }
    .academy-show-card { background:#fff; border:1px solid var(--border); border-radius:16px; box-shadow:0 12px 28px rgba(10,29,68,.08); overflow:hidden; margin-bottom:22px; }
    .academy-show-header { background:linear-gradient(135deg,var(--navy),var(--navy2)); color:#fff; padding:28px; display:flex; justify-content:space-between; gap:18px; flex-wrap:wrap; }
    .academy-show-header h1 { color:#fff; margin:0 0 8px; font-weight:900; }
    .academy-show-header p { color:rgba(255,255,255,.82); margin:0; }
    .academy-show-body { padding:22px; }
    .academy-btn { display:inline-flex; align-items:center; gap:8px; border-radius:999px; padding:10px 18px; font-weight:800; text-decoration:none; }
    .academy-btn-yellow { background:linear-gradient(135deg,var(--yellow),#EBD789); color:var(--navy); }
    .academy-btn-soft { background:#fff; color:var(--navy); border:1px solid var(--border); }
    .score-grid { display:grid; grid-template-columns:repeat(5,minmax(120px,1fr)); gap:12px; }
    .score-card { background:var(--ivory); border:1px solid var(--border); border-radius:14px; padding:16px; }
    .score-card span { color:#6B7280; display:block; font-size:.72rem; font-weight:800; text-transform:uppercase; }
    .score-card strong { color:var(--navy); font-size:1.45rem; }
    .content-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; }
    .panel { background:#fff; border:1px solid var(--border); border-radius:14px; padding:16px; }
    .panel h2 { color:var(--navy); font-size:1rem; font-weight:850; margin-bottom:10px; }
    .correction { border-bottom:1px solid var(--border); padding:10px 0; }
    .correction:last-child { border-bottom:0; }
    @media(max-width:800px){ .score-grid,.content-grid{grid-template-columns:1fr;} .academy-show-page{padding:14px;} }
</style>
@endpush

@section('content')
@php $score = fn ($value) => is_null($value) ? 'N/A' : number_format($value, 1) . '/10'; @endphp
<div class="academy-show-page">
    <div class="academy-show-wrap">
        <div class="mb-3 d-flex gap-2 flex-wrap">
            <a href="{{ route('dashboard.educonecx-academy.index') }}" class="academy-btn academy-btn-soft"><i class="fas fa-arrow-left"></i> Back to Academy Dashboard</a>
            <a href="{{ route('educonecx.academy.index') }}" class="academy-btn academy-btn-yellow"><i class="fas fa-play"></i> Practice Again</a>
        </div>

        <section class="academy-show-card">
            <div class="academy-show-header">
                <div>
                    <h1>{{ $session->scenario->title ?? 'Academy Practice Session' }}</h1>
                    <p>{{ $session->category->title ?? 'No category' }} • {{ optional($session->created_at)->format('M d, Y g:i A') }} • {{ ucfirst($session->status ?? 'pending') }}</p>
                    <p>Avatar: LiveAvatar • Context: {{ $session->scenario->title ?? 'Academy scenario' }}</p>
                </div>
                @if(config('app.debug'))
                    <details>
                        <summary>Debug IDs</summary>
                        <small>avatar_id: {{ $session->heygen_avatar_id ?: '-' }}<br>context_id: {{ $session->heygen_context_id ?: '-' }}<br>voice_id: {{ $session->heygen_voice_id ?: '-' }}</small>
                    </details>
                @endif
            </div>
            <div class="academy-show-body">
                <div class="score-grid">
                    <div class="score-card"><span>Overall</span><strong>{{ $score($session->overall_score) }}</strong></div>
                    <div class="score-card"><span>Pronunciation</span><strong>{{ $score($session->pronunciation_score) }}</strong></div>
                    <div class="score-card"><span>Grammar</span><strong>{{ $score($session->grammar_score) }}</strong></div>
                    <div class="score-card"><span>Fluency</span><strong>{{ $score($session->fluency_score) }}</strong></div>
                    <div class="score-card"><span>Vocabulary</span><strong>{{ $score($session->vocabulary_score) }}</strong></div>
                </div>

                @if($audioUrl)
                    <div class="panel mt-4">
                        <h2>Audio Recording</h2>
                        <audio controls src="{{ $audioUrl }}" style="width:100%;"></audio>
                    </div>
                @endif
            </div>
        </section>

        <section class="content-grid">
            <div class="panel"><h2>Transcript</h2><p>{!! nl2br(e($session->transcript ?? 'No transcript saved yet.')) !!}</p></div>
            <div class="panel"><h2>Feedback</h2><p>{!! nl2br(e($session->feedback ?? 'No feedback saved yet.')) !!}</p></div>
            <div class="panel"><h2>Strengths</h2>@forelse(($session->strengths ?? []) as $item)<p><i class="fas fa-check text-success"></i> {{ $item }}</p>@empty<p>No strengths saved yet.</p>@endforelse</div>
            <div class="panel"><h2>Weaknesses</h2>@forelse(($session->weaknesses ?? []) as $item)<p><i class="fas fa-exclamation-triangle text-warning"></i> {{ $item }}</p>@empty<p>No weaknesses saved yet.</p>@endforelse</div>
            <div class="panel"><h2>Next Steps</h2>@forelse(($session->next_steps ?? []) as $item)<p><i class="fas fa-arrow-right"></i> {{ $item }}</p>@empty<p>No next steps saved yet.</p>@endforelse</div>
            <div class="panel"><h2>Corrections</h2>@forelse(($session->corrections ?? []) as $item)<div class="correction"><p><strong>Original:</strong> {{ data_get($item, 'original') }}</p><p><strong>Corrected:</strong> {{ data_get($item, 'corrected') }}</p><p class="text-muted">{{ data_get($item, 'explanation') }}</p></div>@empty<p>No corrections saved yet.</p>@endforelse</div>
        </section>
    </div>
</div>
@endsection
