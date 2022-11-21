<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function dashboard()
    {
        return view('stock.dashboard');
    }

    public function login(Request $request){
             $URL  =baseUrl().'/login';
        try{
           $result  =  Http::post($URL,
                [
                    'username'=>$request->username,
                    'password'=> $request->password
                ]
            );
        $result_api = json_decode($result);
            if($result_api->success !=true){
                Session::flash('error','Incorrect password or username');
                return redirect('/')->withInput();
            }

            $token = cookie('access_token',  $result_api->access_token, 240);
            $fullname = cookie('name',  $result_api->user->name, 240);
           $username = cookie('username',  $result_api->user->username, 240);
          
            
            Session::flash('success',' '. $result_api->message);
            return redirect('dashboard')
                   ->withCookies([$token, $fullname, $username,]);

        } catch (Throwable $exception){

            
            Log::error('LOGIN-ERROR',['MESSAGE'=>$exception]);
            
            Session::flash('error',' Server error ');

            return redirect('/')->withInput();
        }

    }


    public function logout(){
        $api = baseUrl().'/logout';

     $logout = Http::withToken(token())->get($api);

         $logout_api = json_decode($logout);

        if ($logout_api->success==true)
        {
            $token = Cookie::forget('access_token');

            $fullname = Cookie::forget('name');

            $username = Cookie::forget('username');
           


            Session::flash('success',''.$logout_api->message);

            return redirect('/')->withCookie($token)->withCookie($fullname)->withCookie($username);
        }
        else
        {
            Session::flash('error',''.$logout->message);

            return back();
        }
    }
}
