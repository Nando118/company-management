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
                    $btn .= '<a href="' . route("employee.edit", $row->id) .  '" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-fw fa-edit"></i></a> ';
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
            "email" => "required|string|email:dns|max:255|unique:employees,email",
            "phone" => "required|string|max:20|unique:employees,phone|regex:/^\d{10,15}$/"
        ]);

        if ($validatedData) {
            $result = Employee::query()->create($validatedData);

            if ($result) {
                return redirect()->route('employee.index')
                    ->with('success', 'Successfully adding new employee!');
            }

            return redirect()->back()
                ->with('error', 'An error occurred while adding a new employee!');
        } else {
            return redirect()->back()
                ->with('error', 'An error occurred while adding a new employee!');
        }
    }

    public function edit($employee)
    {
        $employeeData = Employee::with('company')->findOrFail($employee);
        $action = route("employee.update", $employeeData['id']);
        $method = "post";

        if ($employeeData) {
            return view("employee.form.form", [
                "title" => "Company Management | Edit Employee Data",
                "employeeData" => $employeeData,
                "action" => $action,
                "method" => $method,
            ]);
        }

        return redirect()->route('employee.index')
            ->with('error', 'Employee not found!');
    }

    public function update(Request $request)
    {
        $employee = Employee::query()->where('id', $request['id'])->first();

        $rules = array(
            "first_name" => "required|string|min:3|max:80",
            "last_name" => "required|string|min:3|max:80",
            "company_id" => "required"
        );

        if ($request->has("email")) {
            $newEmail = $request->input('email');
            $currentEmail = $employee->email;

            if ($newEmail !== $currentEmail) {
                $rules['email'] = "required|string|email:dns|max:255|unique:employees,email";
            }
        }

        if ($request->has("phone")) {
            $newPhone = $request->input('phone');
            $currentPhone = $employee->phone;

            if ($newPhone !== $currentPhone) {
                $rules['phone'] = "required|string|max:20|unique:employees,phone|regex:/^\d{10,15}$/";
            }
        }

        $validatedData = $request->validate($rules);

        if ($validatedData) {

            $data = [
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'company_id' => $validatedData['company_id']
            ];

            if ($request->has("email")) {
                $data['email'] = $request->input("email");
            }

            if ($request->has("phone")) {
                $data['phone'] = $request->input("phone");
            }

            $employee->update($data);

            return redirect()->route('employee.index')
                ->with('success', 'Successfully updating employee data!');
        } else {
            return redirect()->route('employee.index')
                ->with('error', 'Failed to update employee data!');
        }
    }
}
