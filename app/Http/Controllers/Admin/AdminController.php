<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function feedback()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return view('admin.contacts.list', ['contacts' => $contacts]);
    }
}
