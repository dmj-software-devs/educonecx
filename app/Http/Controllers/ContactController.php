<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers\TranslationHelper;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        // Get the form type to handle different form structures
        $formType = $request->input('form_type', 'default');
        
        // Prepare data array
        $data = [];
        
        if ($formType === 'neo') {
            // NEO ED-TECH form validation
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'required|email|max:255',
                'company' => 'nullable|string|max:255',
                'service' => 'nullable|string|max:255',
                'message' => 'required|string',
            ]);
            
            // Map NEO form fields to standard format
            $data = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'] ?? '',
                'email' => $validated['email'],
                'phone' => '', // No phone field in NEO form
                'subject' => $validated['service'] ?? 'General Inquiry',
                'company' => $validated['company'] ?? '',
                'message' => $validated['message'],
                'form_type' => 'neo'
            ];
        } else {
            // Default contact form validation
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'subject' => 'nullable|string|max:255',
                'message' => 'required|string',
            ]);
            
            $data = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? '',
                'subject' => $validated['subject'] ?? 'General Inquiry',
                'message' => $validated['message'],
                'form_type' => 'default'
            ];
        }

        try {
            // Send email to the company
            Mail::send('emails.contact', ['data' => $data], function ($message) use ($data) {
                $subject = $data['form_type'] === 'neo' 
                    ? 'NEO ED-TECH Inquiry: ' . $data['first_name'] . ' ' . $data['last_name']
                    : 'New Contact Form Submission: ' . $data['first_name'] . ' ' . $data['last_name'];
                
                $message->to('contact@educonecx.com')
                    ->subject($subject)
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->replyTo($data['email'], $data['first_name'] . ' ' . $data['last_name']);
            });

            // Send auto-reply to the user
            Mail::send('emails.auto-reply', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'], $data['first_name'] . ' ' . $data['last_name'])
                    ->subject('Thank you for contacting EDUCANECX')
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            // Check if it's an AJAX request (from NEO page)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your message. We will get back to you soon!'
                ]);
            }

            // Redirect back with success message for standard form
            return redirect()->route('contact')->with('success', 'Thank you for your message. We will get back to you soon!');
            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Contact form email failed: ' . $e->getMessage());

            // Check if it's an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, there was an error sending your message. Please try again later.'
                ], 500);
            }

            // Redirect back with error message
            return redirect()->route('contact')->with('error', 'Sorry, there was an error sending your message. Please try again later.');
        }
    }
}