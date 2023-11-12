<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index() {
        if (\request()->ajax()){
            $data_builder = Employee::all();
            return DataTables::of($data_builder)
                ->addColumn('company_id', function ($data){
                    return $data->company->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group mr-1">';
                    $btn .= '<a href="#" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-fw fa-edit"></i></a> ';
                    $btn .= '<button type="button" class="delete btn btn-danger btn-sm" title="Delete" data-url="#"><i class="fas fa-fw fa-trash"></i></button> ';
                    $btn .= '</div>';
                    return $btn;
                })
                ->toJson();
        }

        return view("employee.index", [
            "title" => "Company Management | Employees List"
        ]);
    }

    public function create() {
        $action = route('employee.store');
        $method = "post";

        return view("employee.form.form", [
            "title" => "Company Management | Add New Employee",
            "action" => $action,
            "method" => $method,
        ]);
    }

    public function getCompanies() {
        $companies = Company::all();
        return response()->json(["companies" => $companies]);
    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            "first_name" => "required|string|min:3|max:80",
            "last_name" => "required|string|min:3|max:80",
            "company_id" => "required",
        ]);

        return $validatedData;
    }
}
