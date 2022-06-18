<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|unique:users',
            'bb' => 'required',
            'tb' => 'required',
            'usia' => 'required',
            'gender' => 'required',
        ]);

        if($validator->fails()){
            return response()
                ->json(['success' => false,'message' => 'Pastikan data dimasukkan dengan lengkap!'], 401);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'bb' => $request->bb,
                'tb' => $request->tb,
                'usia' => $request->usia,
                'gender' => $request->gender,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'fcm_token' => $request->fcm_token,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil register!',
                    'data' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal register! Error : '.$e->getMessage(),
                ]);
        }
    }
    
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required',
            'bb' => 'required',
            'tb' => 'required',
            'usia' => 'required',
            'gender' => 'required',
        ]);

        if($validator->fails()){
            return response()
                ->json(['success' => false,'message' => 'Pastikan data dimasukkan dengan lengkap!'], 401);
        }

        try {
            $user = User::where('id', auth()->user()->id)->first();

                $user->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'bb' => $request->bb,
                    'tb' => $request->tb,
                    'usia' => $request->usia,
                    'gender' => $request->gender,
                    'email' => $request->email,
                    'alamat' => $request->alamat,
                    'password' => Hash::make($request->password)
                ]);

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil update profil!',
                    'data' => $user
                ]);
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal update profil! Error : '.$e->getMessage(),
                ]);
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['success' => false,'message' => 'Unauthorized'], 401);
        }
        try {

            $user = User::where('email', $request['email'])
                ->first();
            if($request->fcm_token!=null){
                $user->update(['fcm_token' => $request->fcm_token]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil login!',
                    'data' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal login! Error : '.$e->getMessage(),
                ]);
        }
    }

    // method for user logout and delete token
    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil logout!',
                ]);
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal logout! Error : '.$e->getMessage(),
                ]);
        }
    }

    public function profile(Request $request){
        if(!auth()){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ]);
        }
        try {
            $user = auth()->user();
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil menampilkan profil!',
                    'data' => $user
                ]);
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal menampilkan profil! Error : '.$e->getMessage(),
                ]);
        }
    }
}
