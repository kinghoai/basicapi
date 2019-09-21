<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request) {
        try{
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = User::where('email',$request->email)->first();
                Auth::login($user);
                //$user = Auth::user();
                $token = $user->createToken('LOGIN')->accessToken;
                $user['token'] = $token;
    
                return $this->dataSuccess('Đăng nhập thành công',$user,200);
            }
            else
            {
                return $this->dataError('Tên đăng nhập hoặc mật khẩu không đúng',[],422);
            }
        }catch(\Exception $exception){
            return $this->dataError($exception->getMessage(),[],422);
        }
    }
}
