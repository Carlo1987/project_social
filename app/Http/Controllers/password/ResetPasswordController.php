<?php

namespace App\Http\Controllers\password;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;   //  aggiunto per gestire la password
use Illuminate\Auth\Events\PasswordReset;  //  aggiunto per gestire reset della password
use Illuminate\Support\Facades\Hash;   //  aggiunto per criptare la nuova password
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;      //   aggiunto per inserire ora e data nel database
use Illuminate\Support\Facades\Mail;   // aggiunto per inviare email
use Illuminate\Support\Facades\DB;    // da usare se avessi usato consulte dirette al database

class ResetPasswordController extends Controller
{

///////////////////////     PAGINA PER INVIARE LINK DI RESET     //////////////////////

    public function show(){
        return view('auth.passwords.email');
    }


    ///////////////////////     CREA E INVIA LINK PER IL RESET ALL ' EMAIL     //////////////////////

    public function email(Request $request){
        $text_validate = json_decode($request->input('text_validate'),true);

        $request->validate(['email' => 'required|email']);
        $email = $request->input('email');
 
       $user_email = User::where('email',$email)->first();

       if($user_email){

        $token = Str::random(64);

        DB::table('password_resets')->insert([
         'email' => $email,
         'token' => $token,
         'created_at' => Carbon::now(),
        ]);
 
         Mail::send('auth.emails.reset_password', ['token' => $token, 'text_validate'=>$text_validate], function($message) use ($request){
             $message->to($request->input('email'));
             $message->subject('Link Reset Password');
         });
 
         return redirect()->route('password.request')->with(['success'=>$text_validate['link_sended']]);
       
        }else{
            return redirect()->route('password.request')->with(['error_user'=> $text_validate['no_user']]);
        }


    }


    ///////////////////////    PAGINA PER CREARE UNA NUOVA PASSWORD      //////////////////////

    public function reset($token){
        return view('auth.passwords.reset', ['token' => $token]);
    }


    ///////////////////////     SALVA NUOVA PASSWORD     //////////////////////

    public function update(Request $request){
        $text_validate = json_decode($request->input('text_validate'),true);
        
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required',
        ]);

        $email = $request->input('email');
        $token = $request->input('token');
        $password = $request->input('password');
        $confirm = $request->input('password_confirmation');

        if($password == $confirm){
            $control = DB::table('password_resets')->where('email',$email)->where('token',$token)->first();
 
            if($control){
        
                $user = User::where('email',$email);
                $user->update(['password' => Hash::make($password)]);
        
                DB::table('password_resets')->where('email',$email)->delete();
        
                return redirect()->route('login.view')->with(['message'=> $text_validate['password_success']]); 

            }else{
                return redirect()->back()->with(['error_reset'=>$text_validate['error_email']]);
            }
        }else{
            return redirect()->back()->with(['error_reset'=>$text_validate['wrong_password']]);
        }

       
    }
}
