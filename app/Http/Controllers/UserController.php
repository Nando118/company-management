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
            $data_builder = User::where('email', '!=', 'admin@admin.com')->get();
            return DataTables::of($data_builder)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group mr-1">';
                    $btn .= '<a href="'. route('user.edit', $row->id) .'" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-fw fa-edit"></i></a> ';
                    $btn .= '<button type="button" class="delete btn btn-danger btn-sm" title="Delete" data-url="' . route('user.delete', $row->id) . '"><i class="fas fa-fw fa-trash"></i></button> ';
                    $btn .= '</div>';
                    return $btn;
                })
                ->toJson();
        }

        return view("user.index", [
            "title" => "Company Management | User List"
        ]);
    }

    public function create() {
        $action = route("user.store");
        $method = "post";

        return view("user.form.form", [
            "title" => "Company Management | Add New User",
            "action" => $action,
            "method" => $method,
        ]);
    }

    public function store(Request $request) {
        $valid = $request->validate([
            "name" => "required|string|min:3|max:70",
            "email" => "required|string|email:dns|max:255|unique:users",
            "password" => "required|string|min:6|confirmed",
        ]);

        if ($valid) {
            $data = [
                'name' => $valid['name'],
                'email' => $valid['email'],
                'password' => bcrypt($valid['password'])
            ];

            $result = User::create($data);

            if ($result) {
                return redirect()->route('user.index')
                    ->with('success', 'Successfully adding new user!');
            }

            return redirect()->back()
                ->with('error', 'An error occurred while adding a new user!');

        } else {
            return redirect()->back()
                ->with('error', 'An error occurred while adding a new user!');
        }
    }

    public function edit($user) {
        $userData = User::findOrFail($user);
        $action = route("user.update", $userData['id']);
        $method = "post";

        if ($userData) {
            return view("user.form.form", [
                "title" => "Company Management | Edit User Data",
                "userData" => $userData,
                "action" => $action,
                "method" => $method,
            ]);
        }

        return redirect()->route('user.index')
            ->with('error', 'User not found!');
    }

    public function update(Request $request) {

        $user = User::where('id', $request['id'])->first();

        $rules = array(
            "id" => "required",
            "name" => "required|string|min:3|max:70",
            "email" => "required|string|email:dns|max:255",
        );

        if ($request['email']) {
            $newEmail = $request->input('email');
            $currentUserEmail = $user->email;

            if ($newEmail !== $currentUserEmail) {
                $rules['email'] = 'required|string|email:dns|max:255|unique:users';
            }
        }

        if ($request['password']) {
            $rules["password"] = "required|string|min:6|confirmed";
        }

        $valid = $request->validate($rules);

        if ($valid) {
            $data = [
                'name' => $valid['name'],
                'email' => $valid['email'],
            ];

            if ($request['password']) {
                $data['password'] = bcrypt($valid['password']);
            }

            $user->update($data);

            return redirect()->route('user.index')
                ->with('success', 'Successfully updating user data!');
        } else {
            return redirect()->route('user.index')
                ->with('error', 'Failed to update user data!');
        }
    }

    public function delete($user) {
        $userData = User::findOrFail($user);

        if ($userData) {
            $userData->delete();
        } else {
            return response([
                'success' => false,
                'error' => 'User data not found!'
            ]);
        }
        return response([
            'success' => true
        ]);
    }
}
