@extends('layouts.main')

@section('title', 'Practice Room Dashboard')

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

    .coach-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
    .coach-card, .context-card { border: 1px solid var(--academy-border); border-radius: 14px; padding: 14px; background: #fff; position: relative; }
    .coach-card.selected, .context-card.selected { border: 2px solid var(--academy-navy); box-shadow: 0 0 0 4px rgba(251, 198, 12, .22); }
    .academy-coach-preview { width: 100%; height: 170px; background: #f8f3dd; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
    .academy-coach-image-wrap { width: 100%; height: 150px; border-radius: 14px; overflow: hidden; background: #f8f3dd; margin-bottom: 12px; }
    .academy-coach-image { width: 100%; height: 100%; object-fit: cover; display: block; }
    .academy-avatar-img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .academy-coach-placeholder { height: 150px; display: flex; align-items: center; justify-content: center; background: #f8f3dd; border-radius: 14px; font-size: 42px; color: var(--academy-navy); margin-bottom: 12px; }
    .coach-name, .context-name { color: var(--academy-navy); font-weight: 850; margin-bottom: 8px; }
    .selected-badge { position:absolute; top:10px; right:10px; background: var(--academy-yellow); color: var(--academy-navy); border-radius:999px; padding:4px 8px; font-size:.72rem; font-weight:900; }
    .context-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; }

    .academy-table-wrap { overflow-x: auto; }
    .academy-table { width: 100%; border-collapse: collapse; min-width: 1050px; }
    .academy-table th { background: var(--academy-navy); color: #fff; padding: 12px; font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; }
    .academy-table td { border-bottom: 1px solid var(--academy-border); padding: 12px; color: var(--academy-navy); vertical-align: middle; }
    .score-pill, .status-pill { border-radius: 999px; padding: 5px 9px; font-weight: 800; font-size: .78rem; display:inline-flex; }
    .score-pill { background: var(--academy-ivory); color: var(--academy-navy); }
    .status-pill { background: rgba(90, 209, 228, .17); color: var(--academy-navy); text-transform: capitalize; }


    .academy-chart-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
    .academy-chart-card { border: 1px solid var(--academy-border); border-radius: 14px; padding: 16px; background: #fff; box-shadow: 0 8px 20px rgba(10, 29, 68, .05); }
    .academy-chart-card h3 { color: var(--academy-navy); font-size: 1rem; font-weight: 850; margin: 0 0 14px; }
    .academy-chart-row { display: grid; grid-template-columns: 92px minmax(90px, 1fr) 52px; gap: 10px; align-items: center; margin-bottom: 10px; font-size: .84rem; }
    .academy-chart-row div { height: 10px; background: #f3f4f6; border-radius: 999px; overflow: hidden; }
    .academy-chart-row i { display: block; height: 100%; background: linear-gradient(135deg, var(--academy-yellow), var(--academy-navy-2)); border-radius: inherit; }

    @media (max-width: 1180px) { .coach-grid, .academy-chart-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .context-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 900px) { .academy-dashboard-layout { grid-template-columns: 1fr; } .academy-stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 560px) { .academy-dashboard { padding: 12px; } .academy-stats-grid, .coach-grid, .context-grid, .academy-chart-grid { grid-template-columns: 1fr; } }
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
                <a href="{{ route('my-courses') }}" class="academy-nav-item"><i class="fas fa-book"></i> My Courses</a>
                <a href="{{ route('my-quizzes') }}" class="academy-nav-item"><i class="fas fa-question-circle"></i> My Quizzes</a>
                <a href="{{ route('certificates') }}" class="academy-nav-item"><i class="fas fa-certificate"></i> Certificates</a>

                <div class="academy-nav-title">Practice Room</div>
                <a href="{{ route('educonecx.academy.index') }}" class="academy-nav-item"><i class="fas fa-play-circle"></i> Start Practice</a>
                <a href="#practice-credits" class="academy-nav-item"><i class="fas fa-coins"></i> Credits</a>
                <a href="#session-history" class="academy-nav-item"><i class="fas fa-history"></i> Practice History</a>
                <a href="#performance-reports" class="academy-nav-item"><i class="fas fa-chart-line"></i> Performance Reports</a>
                <a href="#progress-tracking" class="academy-nav-item"><i class="fas fa-bullseye"></i> Progress Tracking</a>
                <a href="#coach-settings" class="academy-nav-item"><i class="fas fa-user-cog"></i> Coach Settings</a>
            </nav>
        </aside>

        <main>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <section class="academy-header-card">
                <div>
                    <h1>Practice Room</h1>
                    <p>Manage your speaking practice with Victoria Clarke, English Coach, and track your progress.</p>
                </div>
                <a href="{{ route('educonecx.academy.index') }}" class="academy-btn-yellow"><i class="fas fa-play"></i> Start Practice</a>
            </section>

            <section class="academy-stats-grid">
                <div class="academy-stat"><span>Total Practice Sessions</span><strong>{{ $stats['total_sessions'] }}</strong></div>
                <div class="academy-stat"><span>Overall Speaking Score</span><strong>{{ $stats['average_overall_score'] ? $stats['average_overall_score'] . '/10' : 'N/A' }}</strong></div>
                <div class="academy-stat"><span>Best Speaking Score</span><strong>{{ $stats['best_score'] ? $stats['best_score'] . '/10' : 'N/A' }}</strong></div>
                <div class="academy-stat"><span>Last Practice</span><strong style="font-size:1rem;">{{ $stats['last_practice_date'] ?? 'No practice yet' }}</strong></div>
            </section>


            <section id="practice-credits" class="academy-card">
                <div class="academy-card-header">
                    <div>
                        <h2 class="academy-card-title">Practice Room Credits</h2>
                        <p class="academy-card-subtitle">Track the internal platform credits used for Practice Room sessions and exams.</p>
                    </div>
                    <a href="{{ route('educonecx.academy.index') }}" class="academy-btn-yellow"><i class="fas fa-play"></i> Use Credits</a>
                </div>
                <div class="academy-card-body">
                    <div class="academy-stats-grid">
                        <div class="academy-stat"><span>Current Credits</span><strong>{{ $creditWallet->balance ?? 0 }}</strong></div>
                        <div class="academy-stat"><span>Lifetime Granted</span><strong>{{ $creditWallet->lifetime_granted ?? 0 }}</strong></div>
                        <div class="academy-stat"><span>Lifetime Purchased</span><strong>{{ $creditWallet->lifetime_purchased ?? 0 }}</strong></div>
                        <div class="academy-stat"><span>Lifetime Used</span><strong>{{ $creditWallet->lifetime_used ?? 0 }}</strong></div>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Balance After</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($creditTransactions ?? [] as $transaction)
                                    @php
                                        $creditLabels = [
                                            'signup_bonus' => 'Signup Bonus',
                                            'practice_usage' => 'Practice Session',
                                            'exam_usage' => 'Speaking Exam',
                                            'refund' => 'Refund',
                                            'purchase' => 'Purchase',
                                            'admin_grant' => 'Admin Grant',
                                            'course_grant' => 'Course Grant',
                                            'adjustment' => 'Adjustment',
                                        ];
                                    @endphp
                                    <tr>
                                        <td>{{ optional($transaction->created_at)->format('M d, Y g:i A') }}</td>
                                        <td>{{ $creditLabels[$transaction->type] ?? Str::headline($transaction->type) }}</td>
                                        <td class="{{ $transaction->amount >= 0 ? 'text-success' : 'text-danger' }}">{{ $transaction->amount >= 0 ? '+' : '' }}{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->balance_after }}</td>
                                        <td>{{ $transaction->description ?: '—' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-muted">No credit transactions yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="performance-reports" class="academy-card">
                <div class="academy-card-header"><div><h2 class="academy-card-title">Performance Reports</h2><p class="academy-card-subtitle">Dashboard summary of your speaking assessment results.</p></div></div>
                <div class="academy-card-body">
                    <div class="academy-stats-grid">
                        <div class="academy-stat"><span>Average Pronunciation</span><strong>{{ $stats['average_pronunciation_score'] ? $stats['average_pronunciation_score'] . '/10' : 'N/A' }}</strong></div>
                        <div class="academy-stat"><span>Average Fluency</span><strong>{{ $stats['average_fluency_score'] ? $stats['average_fluency_score'] . '/10' : 'N/A' }}</strong></div>
                        <div class="academy-stat"><span>Average Grammar</span><strong>{{ $stats['average_grammar_score'] ? $stats['average_grammar_score'] . '/10' : 'N/A' }}</strong></div>
                        <div class="academy-stat"><span>Average Vocabulary</span><strong>{{ $stats['average_vocabulary_score'] ? $stats['average_vocabulary_score'] . '/10' : 'N/A' }}</strong></div>
                        <div class="academy-stat"><span>Total Speaking Time</span><strong>{{ $stats['total_speaking_time'] }}</strong></div>
                    </div>
                    <div class="academy-chart-grid">
                        @foreach(['Score Trend' => $chartData['score_trend'], 'Monthly Progress' => $chartData['monthly_progress'], 'Recent Performance' => $chartData['recent_performance']] as $chartTitle => $items)
                            <div class="academy-chart-card"><h3>{{ $chartTitle }}</h3>@forelse($items as $item)<div class="academy-chart-row"><span>{{ $item['label'] }}</span><div><i style="width: {{ max(4, min(100, ($item['score'] ?? 0) * 10)) }}%"></i></div><strong>{{ $item['score'] ? $item['score'] . '/10' : 'N/A' }}</strong></div>@empty<p class="text-muted mb-0">No report data yet.</p>@endforelse</div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="progress-tracking" class="academy-card">
                <div class="academy-card-header"><div><h2 class="academy-card-title">Progress Tracking</h2><p class="academy-card-subtitle">Visual learning analytics for your coaching journey.</p></div></div>
                <div class="academy-card-body"><div class="academy-stats-grid">
                    <div class="academy-stat"><span>Current Level</span><strong>{{ $stats['current_level'] }}</strong></div>
                    <div class="academy-stat"><span>Practice Streak</span><strong>{{ $stats['practice_streak'] }} days</strong></div>
                    <div class="academy-stat"><span>Completed Sessions</span><strong>{{ $stats['total_sessions'] }}</strong></div>
                    <div class="academy-stat"><span>Average Score</span><strong>{{ $stats['average_overall_score'] ? $stats['average_overall_score'] . '/10' : 'N/A' }}</strong></div>
                    <div class="academy-stat"><span>Improvement</span><strong>{{ $stats['improvement_percentage'] }}%</strong></div>
                </div></div>
            </section>

            <section id="coach-settings" class="academy-card">
                <div class="academy-card-header">
                    <div>
                        <h2 class="academy-card-title">Choose Your English Coach</h2>
                        <p class="academy-card-subtitle">Select the coach profile learners see in the Practice Room.</p>
                    </div>
                </div>
                <div class="academy-card-body">
                    @if(count($avatars))
                        <div class="coach-grid">
                            @foreach($avatars as $avatar)
                                @php
                                    $defaultCoachAvatarId = config('services.heygen.default_avatar_id') ?: '513fd1b7-7ef9-466d-9af2-344e51eeb833';
                                    $avatarId = (string) data_get($avatar, 'id', $defaultCoachAvatarId);
                                    $selectedAvatarId = (string) ($avatarSetting?->heygen_avatar_id ?: $defaultCoachAvatarId);
                                    $selectedCoach = $selectedAvatarId === $avatarId;
                                @endphp
                                <form method="POST" action="{{ route('dashboard.educonecx-academy.avatar-preference') }}" class="coach-card {{ $selectedCoach ? 'selected' : '' }}">
                                    @csrf
                                    @if($selectedCoach)<span class="selected-badge">Selected</span>@endif
                                    @if(!empty($avatar['image_url']))
                                        <div class="academy-coach-image-wrap">
                                            <img src="{{ $avatar['image_url'] }}" alt="{{ $avatar['name'] ?? 'English Coach' }}" class="academy-coach-image" loading="lazy">
                                        </div>
                                    @else
                                        <div class="academy-coach-placeholder"><i class="fas fa-user-tie"></i></div>
                                    @endif
                                    <div class="coach-name">{{ $avatar['name'] ?? 'English Coach' }}</div>
                                    <small class="text-muted d-block mb-2">English Coach<br>{{ ucfirst($avatar['type'] ?? 'coach') }} profile</small><button type="button" class="academy-btn-soft w-100 mb-2"><i class="fas fa-volume-up"></i> Voice Preview</button>
                                    <input type="hidden" name="avatar_id" value="{{ $avatarId }}">
                                    <input type="hidden" name="heygen_avatar_id" value="{{ $avatarId }}">
                                    <input type="hidden" name="avatar_name" value="{{ $avatar['name'] ?? 'English Coach' }}">
                                    <input type="hidden" name="avatar_image_url" value="{{ $avatar['image_url'] ?? '' }}">
                                    <input type="hidden" name="default_voice_id" value="{{ $avatar['default_voice_id'] ?? '' }}">
                                    <input type="hidden" name="default_voice_name" value="{{ $avatar['default_voice_name'] ?? '' }}">
                                    <button type="submit" class="academy-btn-{{ $selectedCoach ? 'soft' : 'navy' }} mt-3 w-100">{{ $selectedCoach ? 'Selected Coach' : 'Select Coach' }}</button>
                                </form>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">No coach profiles are available yet. Please contact support.</div>
                    @endif
                </div>
            </section>

            <section class="academy-card">
                <div class="academy-card-header">
                    <div>
                        <h2 class="academy-card-title">Choose Conversation Scenario</h2>
                        <p class="academy-card-subtitle">Choose the real-world conversation scenario for your next coaching session.</p>
                    </div>
                </div>
                <div class="academy-card-body">
                    @if(count($contexts))
                        <div class="context-grid">
                            @foreach($contexts as $context)
                                @php
                                    $displayScenario = strcasecmp($context['name'] ?? '', 'Language Learning') === 0 ? 'English Speaking Practice' : ($context['name'] ?? 'English Speaking Practice');
                                    $selectedContext = $avatarSetting->heygen_context_id && $avatarSetting->heygen_context_id === ($context['id'] ?? null);
                                @endphp
                                <form method="POST" action="{{ route('dashboard.educonecx-academy.context-preference') }}" class="context-card {{ $selectedContext ? 'selected' : '' }}">
                                    @csrf
                                    @if($selectedContext)<span class="selected-badge">Selected</span>@endif
                                    <div class="context-name">{{ $displayScenario }}</div>
                                    <input type="hidden" name="heygen_context_id" value="{{ $context['id'] }}">
                                    <input type="hidden" name="context_name" value="{{ $context['name'] }}">
                                    <input type="hidden" name="preferred_language" value="{{ $avatarSetting->preferred_language ?: 'en' }}">
                                    <input type="hidden" name="tutor_style" value="{{ $avatarSetting->tutor_style ?: 'friendly and encouraging' }}">
                                    <button type="submit" class="academy-btn-{{ $selectedContext ? 'soft' : 'navy' }} mt-2 w-100">{{ $selectedContext ? 'Selected Scenario' : 'Select Scenario' }}</button>
                                </form>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">No conversation scenarios are available yet. Please contact support.</div>
                    @endif
                </div>
            </section>

            <section id="session-history" class="academy-card">
                <div class="academy-card-header">
                    <div>
                        <h2 class="academy-card-title">Practice History</h2>
                        <p class="academy-card-subtitle">Review your saved practice sessions, exam results, and feedback reports.</p>
                    </div>
                    <button class="academy-btn-soft" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardPracticeHistory" aria-expanded="false" aria-controls="dashboardPracticeHistory"><i class="fas fa-history"></i> Practice History</button>
                </div>
                <div class="collapse" id="dashboardPracticeHistory">
                    <div class="academy-card-body">
                    <div class="academy-table-wrap">
                        <table class="academy-table">
                            <thead>
                                <tr>
                                    <th>Date</th><th>Coach</th><th>Scenario</th><th>Duration</th><th>Pronunciation Score</th><th>Fluency Score</th><th>Grammar Score</th><th>Vocabulary Score</th><th>Overall Score</th><th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($academySessions as $session)
                                    @php
                                        $duration = ($session->started_at && $session->ended_at) ? $session->started_at->diffForHumans($session->ended_at, true) : 'In progress';
                                    @endphp
                                    <tr>
                                        <td>{{ optional($session->created_at)->format('M d, Y g:i A') }}</td>
                                        <td><strong>{{ ($session->session_type ?? 'practice') === 'exam' ? 'Olivia' : 'Victoria Clarke' }}</strong><br><span class="text-muted">{{ ($session->session_type ?? 'practice') === 'exam' ? 'Assessment Supervisor' : 'English Coach' }}</span></td>
                                        <td>{{ $session->scenario->title ?? $session->context_name ?? 'Daily Conversation' }}</td>
                                        <td>{{ $duration }}</td>
                                        <td><span class="score-pill">{{ is_null($session->pronunciation_score) ? 'N/A' : number_format($session->pronunciation_score, 1) }}</span></td>
                                        <td><span class="score-pill">{{ is_null($session->fluency_score) ? 'N/A' : number_format($session->fluency_score, 1) }}</span></td>
                                        <td><span class="score-pill">{{ is_null($session->grammar_score) ? 'N/A' : number_format($session->grammar_score, 1) }}</span></td>
                                        <td><span class="score-pill">{{ is_null($session->vocabulary_score) ? 'N/A' : number_format($session->vocabulary_score, 1) }}</span></td>
                                        <td><span class="score-pill">{{ is_null($session->overall_score) ? 'N/A' : number_format($session->overall_score, 1) }}</span></td>
                                        <td>
                                            <a href="{{ route('dashboard.educonecx-academy.sessions.show', $session) }}" class="academy-btn-navy mb-1">View Report</a>
                                            <a href="{{ route('dashboard.educonecx-academy.sessions.show', $session) }}" class="academy-btn-soft" download>Download Report</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="10" class="text-center py-4">No speaking practice yet. Start your first session with Victoria Clarke.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $academySessions->links() }}</div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>
@endsection
