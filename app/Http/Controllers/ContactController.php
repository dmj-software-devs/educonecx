<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'nullable|string',
        ]);

        // Here you would typically send an email or save to database
        // For now, we'll just flash a success message
        
        // You can uncomment this when you configure your mail
        /*
        Mail::send('emails.contact', $validated, function ($message) use ($validated) {
            $message->to('contact@educonecx.com')
                    ->subject('New Contact Form Submission')
                    ->from($validated['email'], $validated['first_name'] . ' ' . $validated['last_name']);
        });
        */

        // Redirect back with success message
        return redirect()->route('contact')->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}