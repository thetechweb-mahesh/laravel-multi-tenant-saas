<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\UserActiveCompany;
class ActiveCompanyController extends Controller
{
    public function set(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $company = Company::where('id', $data['company_id'])
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        UserActiveCompany::updateOrCreate(
            ['user_id' => auth()->id()],
            ['company_id' => $company->id]
        );

        return response()->json(['message' => 'Active company switched']);
    }
}
