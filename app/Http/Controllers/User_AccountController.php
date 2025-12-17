<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_Account;
use Illuminate\Support\Facades\Hash;


class User_AccountController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'user_email' => 'required|email|unique:user_account,user_email',
            'cooperative_company' => 'nullable',
            'contact_number' => 'nullable',
            'password' => 'required|min:8|confirmed',
            'role' => 'required',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User_Account::create($data);

        return redirect()->back()->with('success', 'User registered successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function Login(Request $request)
    {
        $credentials = $request->validate([
            'user_email' => 'required|email',
            'password'   => 'required',
        ]);

        $user = User_Account::where('user_email', $credentials['user_email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'user_email' => 'Invalid email or password.',
            ])->onlyInput('user_email');
        }

        // Manually login user
        session(['id' => $user->user_id]); // save user id in session

        return redirect('/ai_agent/survey');
    }

    public function Logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
