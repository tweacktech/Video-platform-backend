<?php
namespace App\Http\Controllers;

use App\Traits\Responds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   use Responds;
    // AuthController.php
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            if (! Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $user  = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;



            return $this->success([
                'user'  => $user,
                'token' => $token,
            ], 'Login successful');
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Logout failed', 'error' => $e->getMessage()], 500);
            return $this->error('Login failed', $e->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->success(null, 'Logged out successfully');
        } catch (\Exception $e) {
            return $this->error('Logout failed', $e->getMessage(), 500);
        }
    }
}
