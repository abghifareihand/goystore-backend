<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{

    public function register(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            // If validation passes, create a new user
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            // Generate access token for the new user
            $token = $user->createToken('auth_token')->plainTextToken;

            // Return success response with access token and user data
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Register success',
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user
                ]
            ]);
        } catch (\Exception $error) {
            // Handle any exceptions that occur during user creation
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'code' => 401,
                    'success' => false,
                    'message' => 'Invalid email',
                ], 401);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'code' => 401,
                    'success' => false,
                    'message' => 'Invalid password',
                ], 401);
            }
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Login success',
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user
                ]
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function fetch(Request $request)
    {
        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Data profile user berhasil diambil',
            'data' => $request->user()
        ]);
    }

    public function updateProfile(Request $request)
    {

        $rules = [
            'email' => 'string|email|max:255|unique:users',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Validasi berhasil, lanjutkan dengan pembaruan profil pengguna
        $user = $request->user();
        $user->update();

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'User profile updated successfully.',
            'data' => $user
        ]);
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 401,
                'success' => false,
                'message' => $validator->errors(),
            ], 401);
        }

        if ($request->file('file')) {
            $photo_path = $request->file->store('assets/user', 'public');

            // Simpan foto ke database (url)
            $user = $request->user();
            $user->profile_photo_path = $photo_path;
            $user->update();

            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Upload photo success',
                'photo_path' => $photo_path
            ]);

        }
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Logout success'
        ]);
    }
}
