<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Company as CompanyRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('admin.companies.index', [
            'companies' => $companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = User::orderBy('name')->get();

        if (!empty($request->user)) {
            $user = User::where('id', $request->user)->first();
        }

        return view('admin.companies.create', [
            'users' => $users,
            'selected' => (!empty($user) ? $user : null)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
//        $company = new Company();
//        $company->fill($request->all());
//
//        var_dump($company->getAttributes());
        $createCompany = Company::create($request->all());

        return redirect()->route('admin.companies.index', [
            'company' => $createCompany->id
        ])->with(['message' => 'Empresa criada com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::where('id', $id)->first();
        $users = User::orderBy('name')->get();

        return view('admin.companies.edit', [
            'company' => $company,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        $company = Company::where('id', $id)->first();
        $company->fill($request->all());
        $company->save();

        return redirect()->route('admin.companies.edit', [
            'company' => $company->id
        ])->with(['message' => 'Empresa alterada com sucesso!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
