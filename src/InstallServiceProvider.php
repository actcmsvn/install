<?php

namespace ACTCMS\Install;

use Illuminate\Support\ServiceProvider;
use ACTCMS\Install\ActcmsRo;

class InstallServiceProvider extends ServiceProvider
{

    public function boot(\Illuminate\Contracts\Http\Kernel $mastor) {

        $ldRt = ActcmsRo::ldRt();
        $this->$ldRt(__DIR__.'/routes.php');
        $router = $this->app['router'];
        $mdl = ActcmsRo::pshMdlGrp();
        $router->$mdl(ActcmsRo::gtc(),GoToCore::class);
        $router->$mdl(ActcmsRo::mdNm(),Install::class);
        $this->loadViewsFrom(__DIR__.'/Views', 'Install');
        $segments = request()->segments();
        $segment = end($segments);

        if(($segment != ActcmsRo::acRouter()) && ($segment != ActcmsRo::acRouterSbm())){
            $mdl = ActcmsRo::pshMdl();
            $mastor->$mdl(Install::class);
        }

    }

    public function register()
    {

    }

}
