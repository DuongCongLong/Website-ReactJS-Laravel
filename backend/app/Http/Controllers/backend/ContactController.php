<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $list = Contact ::orderBy('created_at','DESC')
        ->get();
        
        return view("backend.contact.index",compact('list'));
    }
}
