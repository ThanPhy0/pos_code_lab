<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Contact page
    public function contact($user_id)
    {
        $contact_data = Contact::where('user_id', $user_id)->get();
        return view('user.home.contact', compact('contact_data'));
    }

    // Contact message
    public function toContact(Request $request)
    {
        Contact::create([
            'user_id' => $request->userId,
            'title' => $request->title,
            'message' => $request->message
        ]);

        return back();
    }
}
