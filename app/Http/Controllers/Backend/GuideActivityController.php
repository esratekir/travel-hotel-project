<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class GuideActivityController extends Controller
{
    public function GuideOnline() {
        $guides = User::whereHas("roles", function($q){ $q->where("name", "guide"); })->orderBy('last_seen', 'DESC')->get();
        return view('backend.guides.guides_activity', compact('guides'));
    }

    public function UserOnline() {
        $users = User::whereHas("roles", function($q) { $q->where("name", "user"); })->orderBy('last_seen', 'DESC')->get();
        return view('backend.guides.user_activity', compact('users'));
    }
    
}
