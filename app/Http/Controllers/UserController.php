<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['page_title'] = 'User Management';
        $data['users'] = User::get();
        return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'User Management';
        return view('users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData =  $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
            ]);

        try {
            if ($validateData['password'] !== $validateData['password_confirmation']) {
                return redirect()->back()->withErrors(['password' => 'Password and Confirm Password does not match.']);
            }
            $user = new User();
            $user->name = $validateData['name'];
            $user->username = $validateData['username'];
            $user->email = $validateData['email'];
            $user->password = bcrypt($validateData['password']);
            $user->save();

            return redirect()->route('users.index')->with('success', 'User created successfully.');

        } catch (\Throwable $th) {
            return redirect()->route('users.index')->with('error', 'Error creating user.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['page_title'] = 'User Management';
        $data['user'] = User::findOrFail($id);
        return view('users.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $data['page_title'] = 'User Management';
         $data['user'] = User::find($id);
         return view('users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi data
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'confirmed'],
            'password_confirmation' => ['nullable', 'string'],
        ]);

        try {
            // Update data user
            $user->name = $validateData['name'];
            $user->username = $validateData['username'];
            $user->email = $validateData['email'];

            // Update password jika diisi
            if (!empty($validateData['password'])) {
                if ($validateData['password'] !== $validateData['password_confirmation']) {
                    return redirect()->back()->withErrors(['password' => 'Password and Confirm Password does not match.']);
                }
                $user->password = bcrypt($validateData['password']);
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('users.index')->with('error', 'Error updating user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            // Pastikan user tidak menghapus dirinya sendiri
            if (Auth::user()->id == $user->id) {
                return redirect()->route('users.index')->with('error', 'You cannot delete your own profile.');
            }

            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Error deleting user.');
        }
    }

}
