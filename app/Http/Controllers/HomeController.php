<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $users = User::all()->where('email', '!=', 'admin@admin.com')->count();

        return view('home.index', [
            "title" => "Company Management | Home",
            "users" => $users,
        ]);
    }
}
