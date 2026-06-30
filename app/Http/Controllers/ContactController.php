<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        Contact::create($request->all());

        return back()->with('success', 'Message sent successfully.');
    }
    public function index()
    {
        return view('pages.contact');
    }

    public function store(Request $request)
    {
        Contact::create($request->all());

        return back()->with('success', 'Message sent successfully');
    }
}