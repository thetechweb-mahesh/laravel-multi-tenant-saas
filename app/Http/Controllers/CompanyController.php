<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use DB;
class CompanyController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->companies;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'industry' => 'nullable|string',
        ]);

        $company = $request->user()->companies()->create($data);
        return response()->json($company, 201);
    }

    public function update(Request $request, Company $company)
    {
        $this->authorizeCompany($company, $request->user());

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'industry' => 'nullable|string',
        ]);

        $company->update($data);
        return response()->json($company);
    }

    public function destroy(Company $company)
    {
        $user = auth()->user();

        $company = Company::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
    
        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }
    
        $company->delete();
    
        return response()->json(['message' => 'Company deleted successfully.']);
    }

   
    public function switch($companyId)
{
    $user = auth()->user();

    $company = Company::where('id', $companyId)
        ->where('user_id', $user->id)
        ->first();

    if (!$company) {
        return response()->json(['message' => 'Company not found'], 404);
    }

    DB::table('user_active_companies')->updateOrInsert(
        ['user_id' => $user->id],
        ['company_id' => $company->id, 'updated_at' => now(), 'created_at' => now()]
    );

    return response()->json(['message' => 'Active company switched successfully.']);
}

    private function authorizeCompany(Company $company, User $user)
    {
        if ($company->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
    }
}