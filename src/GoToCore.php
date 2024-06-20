<?php

namespace ACTCMS\Install;

use Closure;

class GoToCore{

    public function handle($request, Closure $next)
    {
        $fileExists = file_exists(__DIR__.'/lara.json');
        if ($fileExists && env('PURCHASECODE')) {
            return redirect()->route(ActcmsRo::acDRouter());
        }
        return $next($request);
    }
}
