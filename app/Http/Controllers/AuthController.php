<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function showLogin () {
        return view('login');
    }

    public function doLogin (Request $request) {
        $validated = $request->validate([
            'student_id' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('student_id', $request->student_id)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $request->session()->put('key', $user->student_id);
            DB::table('logs')->insert([
                'user_id' => $user->id,
                'action' => $user->student_id . ' logged in',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'student_id' => 'Invalid Student ID or Password',
        ])->onlyInput('student_id');
    }

    public function logout (Request $request) {
        $student_id = session()->get('key');
        $user = DB::table('users')->where('student_id', $student_id)->first();
        
        if ($user) {
            DB::table('logs')->insert([
                'user_id' => $user->id,
                'action' => $user->student_id . ' logged out',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $request->session()->forget('key');
        $request->session()->flush();
        return redirect('/login');
    }

    public function showRegister () {
        return view('register');
    }
    public function doRegister (Request $request) {
        $validated = $request->validate([
            'student_id' => 'required|unique:users',
            'email' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'course' => 'required',
            'year_level' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required|date',
            'password' => 'required|confirmed|min:6',
        ]);
        DB::table('users')->insert([
            'student_id' => $request->input('student_id'),
            'email' => $request->input('email'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'course' => $request->input('course'),
            'year_level' => $request->input('year_level'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'date_of_birth' => $request->input('date_of_birth'),
            'password' => bcrypt($request->input('password')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user = DB::table('users')->where('student_id', $request->student_id)->first();
        DB::table('logs')->insert([
                'user_id' => $user->id,
                'action' => $user->student_id . ' just registered',
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        $request->session()->put('key', $request->input('student_id'));
        return redirect('/dashboard');
    }

    public function showDashboard (Request $request){
        if ($request->session()->missing('key')) {
            return redirect('/login');
        }
        
        $student_id = session()->get('key');
        $user = DB::table('users')->where('student_id', $student_id)->first();
        
        if ($user) {
            DB::table('logs')->insert([
                'user_id' => $user->id,
                'action' => $user->student_id . ' is on dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return view('dashboard', compact('user'));
    }
    public function showProfile(Request $request){
        if ($request->session()->missing('key')) {
            return redirect('/login');
        }
        
        $student_id = session()->get('key');
        $user = DB::table('users')->where('student_id', $student_id)->first();
        
        if ($user) {
            DB::table('logs')->insert([
                'user_id' => $user->id,
                'action' => $user->student_id . ' viewed profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return view('profile', compact('user'));
    }

    public function updateProfile (Request $request){
        if ($request->session()->missing('key')) {
            return redirect('/login');
        }
        $student_id = session()->get('key');
        $user = DB::table('users')->where('student_id', $student_id)->first();
        if ($user) {
            DB::table('logs')->insert([
                'user_id' => $user->id,
                'action' => $user->student_id . ' updated profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $validated = $request->validate([
            'email' => 'required|unique:users,email,'.$student_id.',student_id',
            'first_name' => 'required',
            'last_name' => 'required',
            'course' => 'required',
            'year_level' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required|date',
            'password' => 'nullable|confirmed|min:6',
        ]);

        $updateData = [
            'email' => $request->input('email'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'course' => $request->input('course'),
            'year_level' => $request->input('year_level'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'date_of_birth' => $request->input('date_of_birth'),
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->input('password'));
        }

        DB::table('users')->where('student_id', $student_id)->update($updateData);

        return redirect('/dashboard')->with('success', 'Profile updated successfully');
    }
}
