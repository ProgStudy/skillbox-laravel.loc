<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

class AdminController extends Controller
{
    public function index()
    {
        $this->nextByRole(['admin']);
        return view('admin.index');
    }

    public function feedback()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return view('admin.contacts.index', ['contacts' => $contacts]);
    }
}
