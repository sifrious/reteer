<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Mail\Mailable;
use App\Mail\BasicEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BasicEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $mail = new BasicEmail(
            'Mary Effing Perry',
            'You are a lovely human and at least an 8x dev'
        );

        Mail::to('mmebit@icloud.com')
            ->send($mail);

        return back()->with('status', 'Your email has been sent!');
    }
}
