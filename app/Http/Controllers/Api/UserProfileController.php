<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index(){
        $userProfile = UserProfile::where(['user_id'=>auth()->user()->id])->first();
        return new UserProfileResource($userProfile);
    }

    public function edit(UserProfileRequest $request){
        $data = $request->validated();

        $updateInfo = UserProfile::where(['user_id'=>auth()->user()->id])->update($data);

        return $request;
    }
}
