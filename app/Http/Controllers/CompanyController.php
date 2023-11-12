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
                    $btn .= '<a href="' . route("company.edit", $row->id) .  '" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-fw fa-edit"></i></a> ';
                    $btn .= '<button type="button" class="delete btn btn-danger btn-sm" title="Delete" data-url="' . route("company.delete", $row->id) .  '"><i class="fas fa-fw fa-trash"></i></button> ';
                    $btn .= '</div>';
                    return $btn;
                })
                ->toJson();
        }

        return view("company.index", [
            "title" => "Company Management | Companies List"
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
     * Show the form for editing the specified resource.
     */
    public function edit($company)
    {
        $companyData = Company::findOrFail($company);
        $action = route("company.update", $companyData['id']);
        $method = "post";

        if ($companyData) {
            return view("company.form.form", [
                "title" => "Company Management | Edit Company Data",
                "companyData" => $companyData,
                "action" => $action,
                "method" => $method,
            ]);
        }

        return redirect()->route('company.index')
            ->with('error', 'Company not found!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $company = Company::where('id', $request['id'])->first();

        $rules = array(
            "company_name" => "required|string|min:3|max:70",
            "company_email" => "required|string|email:dns|max:255",
            "company_website" => "required|string|url"
        );

        if ($request['email']) {
            $newEmail = $request->input('email');
            $currentCompanyEmail = $company->email;

            if ($newEmail !== $currentCompanyEmail) {
                $rules['company_email'] = "required|string|email:dns|max:255|unique:companies,email";
            }
        }

        if ($request->hasFile('company_logo')) {
            $rules['company_logo'] = "required|file|mimes:png,jpg,jpeg|max:500";
        }

        $validatedData = $request->validate($rules);

        if ($validatedData) {
            $data = [
                'name' => $validatedData['company_name'],
                'email' => $validatedData['company_email'],
                'website' => $validatedData['company_website'],
            ];

            if ($request->hasFile('company_logo')) {
                $file = $request->file('company_logo');

                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                $file->storePubliclyAs("company_image", $fileName, "public");

                $validatedData['company_logo'] = "company_image/" . $fileName;

                $data['logo'] = $validatedData['company_logo'];

                if ($request->oldLogo) {
                    Storage::delete($request->oldLogo);
                }
            }

            $company->update($data);

            return redirect()->route('company.index')
                ->with('success', 'Successfully updating company data!');
        } else {
            return redirect()->route('company.index')
                ->with('error', 'Failed to update company data!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($company)
    {
        $companyData = Company::findOrFail($company);

        if ($companyData) {
            $companyData->delete();
        } else {
            return response([
                'success' => false,
                'error' => 'Company data not found!'
            ]);
        }
        return response([
            'success' => true
        ]);
    }
}
