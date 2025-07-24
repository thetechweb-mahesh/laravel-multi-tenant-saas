<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanySelected
{
  public function handle(Request $request, Closure $next)
    {
        //routes check
        if (
            $request->is('api/register') ||
            $request->is('register') ||
            $request->is('api/login') ||
            $request->is('api/logout') ||
            ($request->is('api/companies') && $request->isMethod('post')) ||
            ($request->is('api/companies/*') && $request->isMethod('put')) ||
            ($request->is('api/companies/*') && $request->isMethod('delete'))||
            $request->is('api/companies/*/switch')
            
        ) {
            return $next($request);
        }

        // user active company
        $user = auth()->user();

        if (!$user || !$user->active_company_id) {
            return response()->json(['message' => 'No active company selected'], 400);
        }

        return $next($request);
    }

}
