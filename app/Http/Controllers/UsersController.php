<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Inertia\Inertia;

use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $users = User::when($request->input('search'), function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%');
        })
        ->whereNot('id', auth()->user()->id)
        ->orderBy('created_at', 'DESC')->paginate(10)->through(function ($item) {
            return [
                'id' => $item->id,
                'avatar' => $item->avatar,
                'name' => $item->name,
                'email' => $item->email,
                'is_admin' => $item->is_admin,
                'created_at' => $item->created_at,
            ];
        });

        return Inertia::render('Users/UsersPage', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsersRequest $request)
    {
        //
        $path = null;

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $fileName = time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('images/avatar/users/', $fileName, 'public');
        }

        User::create([
                        'name' => $request->input('name'), 
                        'avatar' => $path,
                        'email' => $request->input('email'), 
                        'password' => $request->input('password'), 
                        'is_admin' => $request->input('is_admin'),
                    ]);

        return to_route('users')->with('message', 'Usuário criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $course = User::findOrFail($id);
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsersRequest $request, string $id)
    {
        //
        $users = User::findOrFail($id);

        $path = $users->avatar; 

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $fileName = time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('images/avatar/users/', $fileName, 'public');
        }

        $users->update([
            'name' => $request->input('name'), 
            'avatar' => $path,
            'email' => $request->input('email'), 
            'password' => !empty($request->input('password')) ? $request->input('password') : $users->password, 
            'is_admin' => $request->input('is_admin'), 
        ]);

        return to_route('users')->with('message', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        User::findOrFail($id)->delete();

        return to_route('users')->with('message', 'Usuário deletado com sucesso!');
    }
}
