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
        $page = \App\Models\Page::where('slug', 'contact')->where('status', true)->first();
        return view('pages.contact', compact('page'));
    }

    public function store(Request $request)
    {
        Contact::create($request->all());

        return back()->with('success', 'Message sent successfully');
    }
}