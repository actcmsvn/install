<?php

use Illuminate\Support\Facades\Route;
use ACTCMS\Install\Controller\InstallController;
use ACTCMS\Install\ActcmsRo;

Route::middleware(ActcmsRo::gtc())->controller(InstallController::class)->group(function(){
    Route::get(ActcmsRo::acRouter(),'laraStart')->name(ActcmsRo::acRouter());
    Route::post(ActcmsRo::acRouterSbm(),'laraSubmit')->name(ActcmsRo::acRouterSbm());
});
