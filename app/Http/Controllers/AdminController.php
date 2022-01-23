<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Cache;

class AdminController extends Controller
{
    public function index()
    {
        $this->nextByRole(['admin']);
        return view('admin.index');
    }

    public function feedback()
    {
        $contacts = Cache::tags(['contacts'])->rememberForever('AdminController:feedback', function () {
            return Contact::orderBy('created_at', 'desc')->get();
        });

        return view('admin.contacts.index', ['contacts' => $contacts]);
    }
}
