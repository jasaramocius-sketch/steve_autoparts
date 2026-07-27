<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = in_array($request->sort_by, ['id', 'name', 'email', 'subject', 'created_at']) ? $request->sort_by : 'created_at';
        $sortDir = $request->sort_dir === 'asc' ? 'asc' : 'desc';
        $perPage = in_array((int)$request->per_page, [10, 20, 50, 100]) ? (int)$request->per_page : 20;

        $contacts = Contact::with('product')
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        $contacts->appends($request->query())->onEachSide(1);

        return view('admin.contacts.index', compact('contacts', 'sortBy', 'sortDir'));
    }

    public function show($id)
    {
        $contact = Contact::with('product', 'user')->findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return back()->with('success', 'Contact deleted successfully.');
    }
}
