<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckModuleActive
{
    public function handle(Request $request, Closure $next, $moduleAlias)
    {
        $isActive = DB::table('modules')
            ->where('alias', $moduleAlias)
            ->where('enabled', true)
            ->exists();

        if (!$isActive) {
            throw new NotFoundHttpException("Modul {$moduleAlias} tidak aktif.");
        }

        return $next($request);
    }
}
