<?php

namespace App\Http\Controllers;

use App\Models\AcademySession;
use Illuminate\Support\Facades\Storage;

class DashboardAcademySessionController extends Controller
{
    public function show(AcademySession $session)
    {
        abort_unless((int) $session->user_id === (int) auth()->id(), 403);

        $session->load(['category', 'scenario']);
        $audioUrl = $session->audio_path ? Storage::disk('public')->url($session->audio_path) : null;

        return view('dashboard.academy-session-show', compact('session', 'audioUrl'));
    }
}
