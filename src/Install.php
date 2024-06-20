<?php

namespace ACTCMS\Install;

use Closure;

class Install{

    public function handle($request, Closure $next)
    {
        if (!Helpmate::sysPass()) {
            return redirect()->route(ActcmsRo::acRouter());
        }
        abort_if(Helpmate::sysPass() === 99 && request()->isMethod('post'),401);

        return $next($request);
    }
}
