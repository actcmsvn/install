<?php

namespace ACTCMS\Install\Controller;

use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use ACTCMS\Install\ActcmsRo;

class InstallController extends Controller{

    public function laraStart()
    {
        $pageTitle = ActcmsRo::lsTitle();
        return view('Install::lara_start',compact('pageTitle'));
    }

    public function laraSubmit(Request $request){
        $param['code'] = $request->purchase_code;
        $param['url'] = env("APP_URL");
        $param['user'] = $request->envato_username;
        $param['email'] = $request->email;
        $param['product'] = systemDetails()['name'];
        $reqRoute = ActcmsRo::lcLabSbm();
        $response = CurlRequest::curlPostContent($reqRoute, $param);
        $response = json_decode($response);

        if ($response->error == 'error') {
            return response()->json(['type'=>'error','message'=>$response->message]);
        }

        $env = $_ENV;
        $env['PURCHASECODE'] = $request->purchase_code;
        $envString = '';
        $requiredEnv = ['APP_NAME', 'APP_ENV', 'APP_KEY', 'APP_DEBUG', 'APP_URL', 'LOG_CHANNEL', 'DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD','PURCHASECODE'];
        foreach($env as $k => $en){
if(in_array($k , $requiredEnv)){
$envString .= $k.'='.$en.'
';
}
        }

        $envLocation = substr($response->location,3);
        $envFile = fopen($envLocation, "w");
        fwrite($envFile, $envString);
        fclose($envFile);

        $lara = fopen(dirname(__DIR__).'/lara.json', "w");
        $txt = '{
    "purchase_code":'.'"'.$request->purchase_code.'",'.'
    "installcode":'.'"'.@$response->installcode.'",'.'
    "license_type":'.'"'.@$response->license_type.'"'.'
}';
        fwrite($lara, $txt);
        fclose($lara);

        $general = GeneralSetting::first();
        $general->maintenance_mode = 0;
        $general->save();

        return response()->json(['type'=>'success']);

    }
}
