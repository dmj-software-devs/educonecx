@extends('layouts.main')

@section('title', 'EDUCONECX Academy Dashboard')

@push('styles')
<style>
    .academy-dashboard {
        --academy-navy: #0A1D44;
        --academy-navy-2: #18386E;
        --academy-yellow: #FBC60C;
        --academy-ivory: #F9F7E9;
        --academy-white: #FEFDFE;
        --academy-muted: #6B7280;
        --academy-border: rgba(10, 29, 68, 0.10);
        background: linear-gradient(135deg, var(--academy-ivory), var(--academy-white));
        min-height: 100vh;
        padding: 24px;
    }

    .academy-dashboard-layout {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 260px minmax(0, 1fr);
        gap: 24px;
    }

    .academy-sidebar,
    .academy-card {
        background: var(--academy-white);
        border: 1px solid rgba(251, 198, 12, 0.12);
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(10, 29, 68, 0.08);
        overflow: hidden;
    }

    .academy-sidebar-header {
        background: linear-gradient(135deg, var(--academy-navy), var(--academy-navy-2));
        color: #fff;
        padding: 20px;
        text-align: center;
    }

    .academy-sidebar-nav { padding: 14px; }
    .academy-nav-title { color: var(--academy-muted); font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; margin: 12px 10px 8px; }
    .academy-nav-item { display: flex; align-items: center; gap: 10px; color: var(--academy-navy); text-decoration: none; padding: 11px 12px; border-radius: 10px; font-weight: 650; margin-bottom: 6px; }
    .academy-nav-item:hover, .academy-nav-item.active { color: var(--academy-navy); background: linear-gradient(135deg, var(--academy-yellow), #EBD789); text-decoration: none; }

    .academy-header-card {
        background: radial-gradient(circle at top right, rgba(251, 198, 12, .28), transparent 32%), linear-gradient(135deg, var(--academy-navy), var(--academy-navy-2));
        color: #fff;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 16px 35px rgba(10, 29, 68, .16);
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .academy-header-card h1 { color: #fff; font-weight: 900; margin: 0 0 8px; }
    .academy-header-card p { color: rgba(255,255,255,.82); margin: 0; }

    .academy-btn-yellow, .academy-btn-navy, .academy-btn-soft {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-radius: 999px; padding: 10px 18px; font-weight: 800; text-decoration: none; border: 0;
    }
    .academy-btn-yellow { background: linear-gradient(135deg, var(--academy-yellow), #EBD789); color: var(--academy-navy); }
    .academy-btn-navy { background: linear-gradient(135deg, var(--academy-navy), var(--academy-navy-2)); color: #fff; }
    .academy-btn-soft { background: #fff; color: var(--academy-navy); border: 1px solid var(--academy-border); }
    .academy-btn-yellow:hover, .academy-btn-navy:hover, .academy-btn-soft:hover { text-decoration: none; color: inherit; transform: translateY(-1px); }
    .academy-btn-navy:hover { color: #fff; }
    button:disabled { opacity: .45; cursor: not-allowed; }

    .academy-stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 24px; }
    .academy-stat { background: var(--academy-white); border: 1px solid var(--academy-border); border-radius: 14px; padding: 18px; box-shadow: 0 8px 20px rgba(10, 29, 68, .06); }
    .academy-stat span { display: block; color: var(--academy-muted); font-size: .78rem; text-transform: uppercase; font-weight: 800; letter-spacing: .04em; }
    .academy-stat strong { color: var(--academy-navy); font-size: 1.6rem; line-height: 1.2; }

    .academy-card { margin-bottom: 24px; }
    .academy-card-header { padding: 18px 20px; border-bottom: 1px solid var(--academy-border); background: linear-gradient(145deg, #fff, var(--academy-ivory)); display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; }
    .academy-card-title { color: var(--academy-navy); font-weight: 850; margin: 0; font-size: 1.1rem; }
    .academy-card-subtitle { color: var(--academy-muted); margin: 4px 0 0; font-size: .88rem; }
    .academy-card-body { padding: 20px; }

    .avatar-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
    .avatar-card, .context-card, .local-scenario-card { border: 1px solid var(--academy-border); border-radius: 14px; padding: 14px; background: #fff; position: relative; }
    .avatar-card.selected, .context-card.selected { border: 2px solid var(--academy-navy); box-shadow: 0 0 0 4px rgba(251, 198, 12, .22); }
    .avatar-image { height: 150px; border-radius: 12px; background: var(--academy-ivory); display:flex; align-items:center; justify-content:center; overflow:hidden; margin-bottom: 12px; }
    .avatar-image img { width:100%; height:100%; object-fit:cover; }
    .avatar-image i { font-size: 2.3rem; color: var(--academy-navy); }
    .avatar-name, .context-name { color: var(--academy-navy); font-weight: 850; margin-bottom: 8px; }
    .selected-badge { position:absolute; top:10px; right:10px; background: var(--academy-yellow); color: var(--academy-navy); border-radius:999px; padding:4px 8px; font-size:.72rem; font-weight:900; }
    .debug-id { color: var(--academy-muted); font-size: .75rem; word-break: break-all; }

    .context-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; }
    .local-scenario-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-top: 16px; }
    .local-scenario-card small { color: var(--academy-muted); }

    .academy-api-debug { background:#f8fafc; border:1px solid var(--academy-border); border-radius:14px; padding:14px; margin-bottom:16px; }
    .academy-api-debug summary { cursor:pointer; font-weight:850; color:var(--academy-navy); }
    .academy-api-debug pre { white-space:pre-wrap; word-break:break-word; max-height:320px; overflow:auto; background:#fff; border:1px solid var(--academy-border); border-radius:10px; padding:12px; }

    .academy-table-wrap { overflow-x: auto; }
    .academy-table { width: 100%; border-collapse: collapse; min-width: 1050px; }
    .academy-table th { background: var(--academy-navy); color: #fff; padding: 12px; font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; }
    .academy-table td { border-bottom: 1px solid var(--academy-border); padding: 12px; color: var(--academy-navy); vertical-align: middle; }
    .score-pill, .status-pill { border-radius: 999px; padding: 5px 9px; font-weight: 800; font-size: .78rem; display:inline-flex; }
    .score-pill { background: var(--academy-ivory); color: var(--academy-navy); }
    .status-pill { background: rgba(90, 209, 228, .17); color: var(--academy-navy); text-transform: capitalize; }

    @media (max-width: 1180px) { .avatar-grid, .local-scenario-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .context-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 900px) { .academy-dashboard-layout { grid-template-columns: 1fr; } .academy-stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 560px) { .academy-dashboard { padding: 12px; } .academy-stats-grid, .avatar-grid, .context-grid, .local-scenario-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="academy-dashboard">
    <div class="academy-dashboard-layout">
        <aside class="academy-sidebar">
            <div class="academy-sidebar-header">
                <strong>EDUCONECX</strong><br>
                <small>Student Dashboard</small>
            </div>
            <nav class="academy-sidebar-nav">
                <div class="academy-nav-title">Main</div>
                <a href="{{ route('dashboard') }}" class="academy-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a>
                <a href="{{ route('dashboard.educonecx-academy.index') }}" class="academy-nav-item {{ request()->routeIs('dashboard.educonecx-academy.*') || request()->routeIs('educonecx.academy.*') ? 'active' : '' }}"><i class="fas fa-graduation-cap"></i> EDUCONECX Academy</a>
                <a href="{{ route('my-courses') }}" class="academy-nav-item"><i class="fas fa-book"></i> My Courses</a>
                <a href="{{ route('my-quizzes') }}" class="academy-nav-item"><i class="fas fa-question-circle"></i> My Quizzes</a>
                <a href="{{ route('certificates') }}" class="academy-nav-item"><i class="fas fa-certificate"></i> Certificates</a>
            </nav>
        </aside>

        <main>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(config('app.debug'))
                <details class="academy-api-debug">
                    <summary>LiveAvatar Developer API Debug</summary>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4"><strong>Avatar API Status</strong><br>{{ collect($liveAvatarDebug ?? [])->where('type', 'avatars')->pluck('status')->filter()->implode(', ') ?: 'No response' }}</div>
                        <div class="col-md-4"><strong>Context API Status</strong><br>{{ collect($liveAvatarDebug ?? [])->where('type', 'contexts')->pluck('status')->filter()->implode(', ') ?: 'No response' }}</div>
                        <div class="col-md-2"><strong>Avatar Count</strong><br>{{ count($avatars) }}</div>
                        <div class="col-md-2"><strong>Context Count</strong><br>{{ count($contexts) }}</div>
                    </div>
                    <div class="mt-3">
                        <strong>Exact endpoints called</strong>
                        <ul>
                            @foreach(($liveAvatarDebug ?? []) as $debug)
                                <li>{{ $debug['endpoint_url'] ?? '-' }} — status {{ $debug['status'] ?? 'none' }} — count {{ $debug['count'] ?? 0 }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @if(app()->environment('local'))
                        <p class="mb-2"><a href="{{ request()->fullUrlWithQuery(['liveavatar_debug' => 1]) }}">Open raw LiveAvatar JSON debug response</a></p>
                    @endif
                    <pre>{{ json_encode($liveAvatarDebug ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </details>
            @endif

            <section class="academy-header-card">
                <div>
                    <h1>EDUCONECX Academy</h1>
                    <p>Manage your speaking practice, avatar preferences, and progress.</p>
                </div>
                <a href="{{ route('educonecx.academy.index') }}" class="academy-btn-yellow"><i class="fas fa-play"></i> Start New Practice</a>
            </section>

            <section class="academy-stats-grid">
                <div class="academy-stat"><span>Total Sessions</span><strong>{{ $stats['total_sessions'] }}</strong></div>
                <div class="academy-stat"><span>Average Overall</span><strong>{{ $stats['average_overall_score'] ? $stats['average_overall_score'] . '/10' : 'N/A' }}</strong></div>
                <div class="academy-stat"><span>Best Score</span><strong>{{ $stats['best_score'] ? $stats['best_score'] . '/10' : 'N/A' }}</strong></div>
                <div class="academy-stat"><span>Last Practice</span><strong style="font-size:1rem;">{{ $stats['last_practice_date'] ?? 'No practice yet' }}</strong></div>
            </section>

            <section class="academy-card">
                <div class="academy-card-header">
                    <div>
                        <h2 class="academy-card-title">Choose Your AI Avatar</h2>
                        <p class="academy-card-subtitle">Selected public avatars are used on the Academy practice page unless a scenario overrides them.</p>
                    </div>
                </div>
                <div class="academy-card-body">
                    @if(count($avatars))
                        <div class="avatar-grid">
                            @foreach($avatars as $avatar)
                                @php $selectedAvatar = $avatarSetting->heygen_avatar_id && $avatarSetting->heygen_avatar_id === $avatar['id']; @endphp
                                <form method="POST" action="{{ route('dashboard.educonecx-academy.avatar-preference') }}" class="avatar-card {{ $selectedAvatar ? 'selected' : '' }}">
                                    @csrf
                                    @if($selectedAvatar)<span class="selected-badge">Selected</span>@endif
                                    <div class="avatar-image">
                                        @if(!empty($avatar['image_url']))
                                            <img src="{{ $avatar['image_url'] }}" alt="{{ $avatar['name'] }}">
                                        @else
                                            <i class="fas fa-user-astronaut"></i>
                                        @endif
                                    </div>
                                    <div class="avatar-name">{{ $avatar['name'] }}</div>
                                    <small class="text-muted d-block mb-2">{{ ucfirst($avatar['type'] ?? 'public') }} avatar</small>
                                    <div class="debug-id"><strong>Avatar ID:</strong> {{ $avatar['id'] }}</div>
                                    <input type="hidden" name="heygen_avatar_id" value="{{ $avatar['id'] }}">
                                    <input type="hidden" name="avatar_name" value="{{ $avatar['name'] }}">
                                    <input type="hidden" name="avatar_image_url" value="{{ $avatar['image_url'] ?? '' }}">
                                    <button type="submit" class="academy-btn-{{ $selectedAvatar ? 'soft' : 'navy' }} mt-3 w-100">{{ $selectedAvatar ? 'Selected Avatar' : 'Select Avatar' }}</button>
                                </form>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">LiveAvatar API returned 0 avatars. Check the debug section for endpoint status and response body.</div>
                    @endif
                </div>
            </section>

            <section class="academy-card">
                <div class="academy-card-header">
                    <div>
                        <h2 class="academy-card-title">Choose Practice Scenario</h2>
                        <p class="academy-card-subtitle">LiveAvatar contexts control the avatar session. Local scenarios provide the educational practice content.</p>
                    </div>
                </div>
                <div class="academy-card-body">
                    <h3 class="academy-card-title mb-3" style="font-size:1rem;">LiveAvatar Contexts</h3>
                    @if(count($contexts))
                        <div class="context-grid">
                            @foreach($contexts as $context)
                                @php $selectedContext = $avatarSetting->heygen_context_id && $avatarSetting->heygen_context_id === ($context['id'] ?? null); @endphp
                                <form method="POST" action="{{ route('dashboard.educonecx-academy.context-preference') }}" class="context-card {{ $selectedContext ? 'selected' : '' }}">
                                    @csrf
                                    @if($selectedContext)<span class="selected-badge">Selected</span>@endif
                                    <div class="context-name">{{ $context['name'] }}</div>
                                    <div class="debug-id"><strong>Context ID:</strong> {{ $context['id'] }}</div>
                                    <input type="hidden" name="heygen_context_id" value="{{ $context['id'] }}">
                                    <input type="hidden" name="context_name" value="{{ $context['name'] }}">
                                    <input type="hidden" name="preferred_language" value="{{ $avatarSetting->preferred_language ?: 'en' }}">
                                    <input type="hidden" name="tutor_style" value="{{ $avatarSetting->tutor_style ?: 'friendly and encouraging' }}">
                                    <button type="submit" class="academy-btn-{{ $selectedContext ? 'soft' : 'navy' }} mt-2 w-100">{{ $selectedContext ? 'Selected Context' : 'Select Context' }}</button>
                                </form>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">LiveAvatar API returned 0 contexts. Check the debug section for endpoint status and response body.</div>
                    @endif

                    <h3 class="academy-card-title mt-4 mb-3" style="font-size:1rem;">Local Practice Scenarios</h3>
                    <div class="local-scenario-grid">
                        @foreach($categories as $category)
                            @foreach($category->scenarios as $scenario)
                                <div class="local-scenario-card">
                                    <strong>{{ $scenario->title }}</strong>
                                    <small class="d-block">{{ $category->title }} • {{ $scenario->level ?? 'General' }}</small>
                                    <a href="{{ route('educonecx.academy.index') }}" class="academy-btn-soft mt-3 w-100">Practice</a>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="academy-card">
                <div class="academy-card-header">
                    <div>
                        <h2 class="academy-card-title">Practice History</h2>
                        <p class="academy-card-subtitle">Your latest saved Academy sessions and OpenAI evaluations.</p>
                    </div>
                    <a href="{{ route('dashboard.educonecx-academy.history') }}" class="academy-btn-soft"><i class="fas fa-code"></i> JSON</a>
                </div>
                <div class="academy-card-body">
                    <div class="academy-table-wrap">
                        <table class="academy-table">
                            <thead>
                                <tr>
                                    <th>Date</th><th>Scenario</th><th>Category</th><th>Avatar</th><th>Context</th><th>Overall</th><th>Pron.</th><th>Grammar</th><th>Fluency</th><th>Vocabulary</th><th>Status</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($academySessions as $session)
                                    <tr>
                                        <td>{{ optional($session->created_at)->format('M d, Y g:i A') }}</td>
                                        <td>{{ $session->scenario->title ?? 'Academy Practice Session' }}</td>
                                        <td>{{ $session->category->title ?? 'No category' }}</td>
                                        <td>{{ config('app.debug') && $session->heygen_avatar_id ? Str::limit($session->heygen_avatar_id, 12) : 'LiveAvatar' }}</td>
                                        <td>{{ config('app.debug') && $session->heygen_context_id ? Str::limit($session->heygen_context_id, 12) : 'LiveAvatar' }}</td>
                                        <td><span class="score-pill">{{ is_null($session->overall_score) ? 'N/A' : number_format($session->overall_score, 1) }}</span></td>
                                        <td><span class="score-pill">{{ is_null($session->pronunciation_score) ? 'N/A' : number_format($session->pronunciation_score, 1) }}</span></td>
                                        <td><span class="score-pill">{{ is_null($session->grammar_score) ? 'N/A' : number_format($session->grammar_score, 1) }}</span></td>
                                        <td><span class="score-pill">{{ is_null($session->fluency_score) ? 'N/A' : number_format($session->fluency_score, 1) }}</span></td>
                                        <td><span class="score-pill">{{ is_null($session->vocabulary_score) ? 'N/A' : number_format($session->vocabulary_score, 1) }}</span></td>
                                        <td><span class="status-pill">{{ $session->status ?? 'pending' }}</span></td>
                                        <td>
                                            <a href="{{ route('dashboard.educonecx-academy.sessions.show', $session) }}" class="academy-btn-navy mb-1">View Details</a>
                                            <a href="{{ route('educonecx.academy.index') }}" class="academy-btn-soft">Start Again</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="12" class="text-center py-4">No speaking practice yet. Start your first AI avatar practice.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $academySessions->links() }}</div>
                </div>
            </section>
        </main>
    </div>
</div>
@endsection
