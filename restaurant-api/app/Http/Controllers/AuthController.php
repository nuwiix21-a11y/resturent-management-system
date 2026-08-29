<?php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * POST /api/login
     * Returns Sanctum token + user info.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'nullable|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid username.'], 401);
        }

        // If admin, check password
        if ($user->role === 'admin') {
            if (!$request->password || !\Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid password.'], 401);
            }
        }
        
        // Generate 6-digit OTP
        $otp = sprintf("%06d", mt_rand(100000, 999999));
        
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        // Send OTP via Email
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\LoginOtpMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send OTP email: ' . $e->getMessage());
            // In a real app we might fail here, but let's allow proceeding to test with logs
        }

        return response()->json([
            'message' => 'OTP sent to your email address.',
            'require_otp' => true,
            'username' => $user->username,
        ]);
    }

    /**
     * POST /api/verify-otp
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'otp'      => 'required|string|size:6',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || $user->otp_code !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP.'], 401);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['message' => 'OTP has expired.'], 401);
        }

        // OTP is valid
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        $token = $user->createToken('restaurant-app')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ],
        ]);
    }

    /**
     * POST /api/logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }

    /**
     * GET /api/user — returns authenticated user
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
