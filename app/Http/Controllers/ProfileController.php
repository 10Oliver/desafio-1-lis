<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = new UserResource(Auth::user());
        return view('profile.index', compact('user'));
    }

    public function editIndex()
    {
        $user = new UserResource(Auth::user());
        $edit = true;
        return view('profile.index', compact('user', 'edit'));
    }

    public function showPasswordView()
    {
        return view('profile.change-password');
    }

    public function showTwoFactor()
    {
        $activeTab = 3;
        return view('profile.two-factor');
    }

    public function updateUserData(UpdateUserRequest $request)
    {
        $user = Auth::user();

        $user->update($request->all());

        session()->flash('success', '¡Usuario actualizado!');

        $user->refresh();

        return view('profile.index', compact('user'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
