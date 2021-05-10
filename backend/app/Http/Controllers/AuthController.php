<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function postUser(Request $request)
	{
		$validator = $request->validate([
			'name' => 'required|unique:users|min:3|max:50',
			'email' => 'required|email|unique:users',
			'password' => ['required', Password::min(6)->mixedCase()->numbers()],
		]);

		$user = new User;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->save();

		Auth::login($user);

		return response()->json([
			$user
		]);
	}
}