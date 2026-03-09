<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers\TranslationHelper;
use App\Http\Controllers\Log;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        // Validate the form data - include phone and subject
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Send email to the company
            Mail::send('emails.contact', ['data' => $validated], function ($message) use ($validated) {
                $message->to('contact@educonecx.com')
                    ->subject('New Contact Form Submission: ' . $validated['first_name'] . ' ' . $validated['last_name'])
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->replyTo($validated['email'], $validated['first_name'] . ' ' . $validated['last_name']);
            });

            // Optional: Send auto-reply to the user
            Mail::send('emails.auto-reply', ['data' => $validated], function ($message) use ($validated) {
                $message->to($validated['email'], $validated['first_name'] . ' ' . $validated['last_name'])
                    ->subject('Thank you for contacting EDUCANECX')
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            // Redirect back with success message
            return redirect()->route('contact')->with('success', 'Thank you for your message. We will get back to you soon!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Contact form email failed: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->route('contact')->with('error', 'Sorry, there was an error sending your message. Please try again later.');
        }
    }
}
