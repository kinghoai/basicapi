<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;

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

    public function logout() {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);
        $accessToken->revoke();
        return $this->dataSuccess('Đăng xuat thành công',[],200);
    }

    public function register(Request $request) {
//        $request->validate([
//            'email' => 'required',
//            'password' => 'required'
//        ]);
        try{
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            return $this->dataSuccess('Đăng ky thành công',$user,200);
        }catch(\Exception $exception){
            return $this->dataError($exception->getMessage(),[],422);
        }
    }
}
