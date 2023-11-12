<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $users = User::all()->where('email', '!=', 'admin@admin.com')->count();
        $companies = Company::all()->count();
        $employees = Employee::all()->count();

        return view('home.index', [
            "title" => "Company Management | Home",
            "users" => $users,
            "companies" => $companies,
            "employees" => $employees,
        ]);
    }
}
