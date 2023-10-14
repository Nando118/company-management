<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()){
            $data_builder = Company::all();
            return DataTables::of($data_builder)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group mr-1">';
                    $btn .= '<a href="#" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-fw fa-edit"></i></a> ';
                    $btn .= '<button type="button" class="delete btn btn-danger btn-sm" title="Delete" data-url="#"><i class="fas fa-fw fa-trash"></i></button> ';
                    $btn .= '</div>';
                    return $btn;
                })
                ->toJson();
        }

        return view("company.index", [
            "title" => "Company Management | Company List"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('company.store');
        $method = "post";

        return view("company.form.form", [
            "title" => "Company Management | Add New Company",
            "action" => $action,
            "method" => $method,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "company_name" => "required|string|min:3|max:70",
            "company_email" => "required|string|email:dns|max:255|unique:companies,email",
            "company_website" => "required|string|url",
            "company_logo" => "required|file|mimes:png,jpg,jpeg|max:500",
        ]);

        // Cek ada file image yang di upload atau tidak, jika ada nanti akan di simpan dalam direktori company_image
        if ($request->hasFile('company_logo')) {

            $file = $request->file('company_logo');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->storePubliclyAs("company_image", $fileName, "public");

            $validatedData['company_logo'] = "company_image/" . $fileName;
        }

        if ($validatedData) {
            $data = [
                'name' => $validatedData['company_name'],
                'email' => $validatedData['company_email'],
                'logo' => $validatedData['company_logo'],
                'website' => $validatedData['company_website'],
            ];

            $result = Company::create($data);

            if ($result) {
                return redirect()->route('company.index')
                    ->with('success', 'Successfully adding new company!');
            }

            return redirect()->back()
                ->with('error', 'An error occurred while adding a new company!');

        } else {
            return redirect()->back()
                ->with('error', 'An error occurred while adding a new user!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(c $c)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(c $c)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, c $c)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(c $c)
    {
        //
    }
}
