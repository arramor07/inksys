<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact'); // adjust if your view file has a different name
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string|max:5000',
        ]);

        // send email to admin
        Mail::send('emails.contact', ['data' => $data], function ($message) use ($data) {
            $message->to('arramor07@gmail.com', 'InkTech Admin')
                    ->subject('New contact message from InkTech')
                    ->replyTo($data['email'], $data['name']);
        });

        return back()->with('success', 'Your message has been sent. We’ll get back to you soon!');
    }
}
