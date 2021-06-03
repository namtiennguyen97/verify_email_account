<?php

namespace App\Http\Controllers;

use App\Mail\VerifyMail;
use App\Models\User;
use App\Models\VerifyEmailUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registerUser(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_token' => Str::random(60)
        ]);

        $verify = VerifyEmailUser::create([
            'token' => Str::random(60),
            'user_id' => $user->id
        ]);

        Mail::send('mail.verifyMail', [
            'user_token' => $verify->token,
        ], function ($mail) use ($user) {
            $mail->to($user->email); // email se nhan
            $mail->from('namnt@ttc-solutions.com.vn');  // email source gui
            $mail->subject('TTS-PHP');
        });
        return view('verifyEmailAlert');
    }

    public function verifyMail($token)
    {
        $verify = VerifyEmailUser::where('token', '=', $token)->first();
        if (isset($verify)) {
            $user = $verify->user;
            if (!$user->email_verified_at) {
                $user->email_verified_at = Carbon::now();
                $user->save();
                return redirect()->route('login');
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->route('login');
        }
    }

    // sau khi verify email thanh cong

    public function validateLogin(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->email_verified_at == null) {
                Auth::logout();
                return redirect()->route('login');
            }

            Auth::login($user);
            return redirect()->route('home');
        }
    }
}
