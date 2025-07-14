<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthTokenController extends Controller
{
    public function login(Request $request)
{
    $data = $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);
    $user = \App\Models\User::where('email', $data['email'])->first();
    if (!$user || ! Hash::check($data['password'], $user->password)) {
        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }
    $token = $user->createToken('frontend')->plainTextToken;
    return response()->json(['token' => $token], 200);
}
}
