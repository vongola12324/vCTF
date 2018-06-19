<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('manage.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $profile = false;
        $roles = $user->roles;
        return view('manage.user.show', compact('user', 'profile', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $profile = false;
        $roles = Role::all();
        return view('manage.user.edit', compact('user', 'profile', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'        => 'required|string',
            'website'     => 'nullable|url',
            'country'     => 'nullable|string',
            'affiliation' => 'nullable|string',
            'role'       => 'nullable|array'
        ]);

        $user->update([
            'name'        => $request->get('name'),
            'website'     => $request->get('website'),
            'country'     => $request->get('country'),
            'affiliation' => $request->get('affiliation'),
        ]);

        $keepAdmin = false;
        if ($user->id === auth()->id() && $user->hasRole('Admin')) {
            $keepAdmin = true;
        }
        $roles = Role::whereIn('name', array_keys($request->get('role', [])))->get();
        $user->syncRoles($roles);
        if ($keepAdmin && !$user->hasRole('Admin')) {
            $user->attachRole(Role::whereName('Admin')->first());
        }

        return redirect()->route('user.show', $user)->with('success', '隊伍更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
//    public function destroy(User $user)
//    {
//        //
//    }
}
