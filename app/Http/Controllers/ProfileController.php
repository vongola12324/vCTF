<?php

namespace App\Http\Controllers;

use App\User;
use Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $roles = $user->roles;
        $profile = true;
        return view('manage.user.show', compact('user', 'profile', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();
        $profile = true;
        return view('manage.user.edit', compact('user', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $this->validate($request, [
            'name'         => 'required|string',
            'website'      => 'nullable|url',
            'country'      => 'nullable|string',
            'affiliation'  => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->update([
            'name'        => $request->get('name'),
            'website'     => $request->get('website'),
            'country'     => $request->get('country'),
            'affiliation' => $request->get('affiliation'),
        ]);

        if ($request->has('new_password')) {
            $user->update([
                'password' => Hash::make($request->get('new_password'))
            ]);
        }

        return redirect()->route('profile')->with('success', '隊伍更新成功！');
    }
}
