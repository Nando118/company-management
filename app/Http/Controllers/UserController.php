<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index() {

        if (\request()->ajax()){
            $data_builder = User::query()->where('email', '!=', 'admin@admin.com');
            return DataTables::eloquent($data_builder)->toJson();
        }

        return view("user.index", [
            "title" => "User Settings"
        ]);
    }
}
