<?php


namespace App\Services;


use App\Models\CodeSms;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function StoreNewUser($data){

        /** @var \App\Models\User $user **/
        $user = User::create([
            'username'=>$data['username'],
            'password' => bcrypt($data['password'])
        ]);
        $token =  $this->GetTokenUser($user);
        return [
            'user' => $user,
            'token' => $token
        ];
    }
    public function storeSmsCode($data){
        $smsCreate = CodeSms::create([
            'ip'=>request()->ip(),
            'code'=>$data['code'],
            'phone'=>$data['phone'],
            'expires_at'=>date('Y-m-d H:i:s', (time()+5*60))
        ]);

        return $smsCreate;
    }
    public function checkCodeWithPhone($data){
        try {
         return  CodeSms::where(['phone'=>$data['phone'],'code'=>$data['code']])->first;
        }catch (\Exception $e){
            abort(404,    'not found');
        }
    }
    public function isAuth($credentials, $remember) {

        if(!Auth::attempt($credentials, $remember)) {
            return false;
        }
        return  Auth::user();
    }
    public  function GetTokenUser(User $user){
        $token =  $user->createToken('main')->plainTextToken;
        return $token;
    }
}
