<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::where(function($q) {
            if (!User::hasRole(['admin'])) {
                if (User::hasRole(['author'])) { 
                    $q->where('has_public', 1)->orWhere('owner_id', Auth::user()->id);
                } else {
                    $q->where('has_public', 1);
                }
            }
        })->orderBy('created_at', 'desc')->get();

        return view('home', ['articles' => $articles]);
    }

    public function about()
    {
        return view('about');
    }

    public function contacts()
    {
        return view('contacts');
    }

    public function ajaxSendContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'         => 'required|regex:/^([A-z0-9]+\@+[a-z0-9]+\.+[a-z]{2,3})$/i',
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            return $this->ajaxError($validator->errors()->first());
        }
        
        $contact                = new Contact();

        $contact->email         = $request->email;
        $contact->description   = $request->description;

        try {
            $contact->save();
        } catch (Exception $e) {
            return $this->ajaxError('Не удалось сохранить контактные данные!');
        }

        return $this->ajaxSuccess('Контактные данные были отправлены!');
    }
}
