<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CertificateController extends Controller
{
    /**
     * Generate certificate when course is completed
     */
    public function generate(Request $request, $courseId)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login');
            }

            $course = Course::findOrFail($courseId);
            
            // Check if user is enrolled and completed the course
            $enrollment = Enrollment::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->where('progress', 100)
                ->first();

            if (!$enrollment) {
                return redirect()->back()->with('error', 'You need to complete the course first to get a certificate.');
            }

            // Check if certificate already exists
            $existingCertificate = Certificate::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->first();

            if ($existingCertificate) {
                return redirect()->route('certificates.show', $existingCertificate->id);
            }

            // Generate unique certificate number
            $certificateNumber = $this->generateCertificateNumber($user, $course);

            // Create certificate
            $certificate = Certificate::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'enrollment_id' => $enrollment->id,
                'certificate_number' => $certificateNumber,
                'issue_date' => now(),
                'expiry_date' => $enrollment->expiry_date, // If subscription-based, might have expiry
            ]);

            // Update enrollment to mark certificate as generated
            $enrollment->update([
                'certificate_generated' => 1
            ]);

            // Generate PDF (optional - you can implement this later)
            // $this->generatePDF($certificate);

            return redirect()->route('certificates.show', $certificate->id)
                ->with('success', 'Congratulations! Your certificate has been generated.');

        } catch (\Exception $e) {
            Log::error('Certificate generation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error generating certificate: ' . $e->getMessage());
        }
    }

    /**
     * Show certificate
     */
    public function show($id)
    {
        try {
            $user = Auth::user();
            
            $certificate = Certificate::with(['user', 'course'])
                ->where('id', $id)
                ->firstOrFail();

            // Check if user owns this certificate
            if ($certificate->user_id !== $user->id && !$user->is_admin) {
                abort(403, 'Unauthorized access to certificate');
            }

            // Get enrollment details for expiry date if needed
            $enrollment = Enrollment::find($certificate->enrollment_id);

            return view('certificates.show', compact('certificate', 'enrollment'));

        } catch (\Exception $e) {
            Log::error('Certificate view error: ' . $e->getMessage());
            abort(404, 'Certificate not found');
        }
    }

    /**
     * Download certificate as PDF
     */
    public function download($id)
    {
        try {
            $user = Auth::user();
            
            $certificate = Certificate::with(['user', 'course'])
                ->where('id', $id)
                ->firstOrFail();

            // Check if user owns this certificate
            if ($certificate->user_id !== $user->id && !$user->is_admin) {
                abort(403, 'Unauthorized access to certificate');
            }

            // Generate PDF
            $pdf = Pdf::loadView('certificates.pdf', compact('certificate'));
            
            $filename = 'certificate-' . $certificate->course->title . '-' . $certificate->certificate_number . '.pdf';
            $filename = preg_replace('/[^A-Za-z0-9\-.]/', '-', $filename);

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Certificate download error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error downloading certificate');
        }
    }

    /**
     * List user's certificates
     */
    public function index()
    {
        $user = Auth::user();
        
        $certificates = Certificate::with('course')
            ->where('user_id', $user->id)
            ->orderBy('issue_date', 'desc')
            ->paginate(10);

        return view('certificates.index', compact('certificates'));
    }

    /**
     * Generate unique certificate number
     */
    private function generateCertificateNumber($user, $course)
    {
        $prefix = 'EDU';
        $year = now()->year;
        $month = now()->format('m');
        $userId = str_pad($user->id, 4, '0', STR_PAD_LEFT);
        $courseId = str_pad($course->id, 4, '0', STR_PAD_LEFT);
        $random = strtoupper(Str::random(4));
        
        $number = "{$prefix}-{$year}{$month}-{$userId}-{$courseId}-{$random}";
        
        // Ensure uniqueness
        while (Certificate::where('certificate_number', $number)->exists()) {
            $random = strtoupper(Str::random(4));
            $number = "{$prefix}-{$year}{$month}-{$userId}-{$courseId}-{$random}";
        }
        
        return $number;
    }

    /**
     * Verify certificate by number (public route)
     */
    public function verify($certificateNumber)
    {
        try {
            $certificate = Certificate::with(['user', 'course'])
                ->where('certificate_number', $certificateNumber)
                ->firstOrFail();

            return view('certificates.verify', compact('certificate'));

        } catch (\Exception $e) {
            return view('certificates.verify', [
                'error' => 'Certificate not found or invalid certificate number.'
            ]);
        }
    }
}