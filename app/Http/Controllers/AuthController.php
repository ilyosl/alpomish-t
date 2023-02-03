<?php

namespace App\Http\Controllers;

use App\Actions\SendSms;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\LoginWithCodeRequest;
use App\Http\Requests\PhoneSmsRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(RegisterUserRequest $request, AuthService $service){

        $user = $service->SignupWithLogin($request->validated());
        return response($user);
    }

    public function login(LoginUserRequest $request, AuthService $service){
        $credentials = $request->validated();
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if(!($user = $service->isAuth($credentials, $remember))){
            return response([
                'error' => 'Credentials are not correct'
            ], 422);
        }
        $token = $service->GetTokenUser($user);

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }
    public function loginWithSms(LoginWithCodeRequest $request, AuthService $service){
//        dd($request->validationData());
        $data = $request->validated();
        $result = $service->checkCodeWithPhone($data);
        if($result){
            $checkIsNew = User::where(['username'=>$data['phone']])->first();
            if(empty($checkIsNew)){
                $data['username'] = $data['phone'];
                $data['password'] = $data['code'];
                return  $service->StoreNewUser($data);
            }else{
                return ['user'=>$checkIsNew, 'token'=>$service->GetTokenUser($checkIsNew)];
            }
        }else{
            return ['success'=>0, 'code'=>'Code not valid'];
        }

    }
    public function sendSms(PhoneSmsRequest $request, SendSms $action, AuthService $service){
        $phone = $request->validated();
        $checkUser = User::where(['phone'=>$phone['phone']])->first();
        $code = rand(pow(10, 3), pow(10, 4)-1);
        if(empty($checkUser)){
//            $action->sendSms('998331108585','Code: '.$code.' ');
            $isSave = $service->storeSmsCode(['code'=>$code, 'phone'=>$phone['phone']]);
            return ['success'=>1, 'test_code'=>$code,'test_phone'=>$phone['phone'], 'isSave'=>$isSave];
        }else{
            return $service->storeSmsCode(['code'=>$code, 'phone'=>$phone['phone']]);
        }
    }
    public function logout()
    {
        /** @var User $user **/
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }

}
