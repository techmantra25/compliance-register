<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::guard('admin')->user();

        // Not logged in
        if (!$user) {
            abort(403, 'You are not authorized');
        }

        // SUPER ADMIN bypass (user ID = 1)
        if ($user->id == 1) {
            return $next($request);
        }

        // Check permission exists
        $userPermission = DB::table('permissions')->where('slug', $permission)->first();

        if (!$userPermission) {
            abort(403, 'Permission Not Found');
        }

        $userPermissions = $user->getPermissionAttribute(); // already an array

        if (!in_array($userPermission->id, $userPermissions)) {
            abort(403, 'Permission Denied');
        }

        return $next($request);
    }

}
