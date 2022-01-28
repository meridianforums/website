<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAccountRequest;

class UserAccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('account');
    }

    /**
     * @param \App\Http\Requests\UserAccountRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserAccountRequest $request): \Illuminate\Http\RedirectResponse
    {
        $request->user()->update([
            'name'    => $request->get('name'),
            'username'    => $request->get('username'),
            'email'   => $request->get('email'),
        ]);

        if ($request->filled('password'))
        {
            $request->user()->update(['password' => bcrypt($request->get('password'))]);
        }

        session()->flash('success', trans('app.account_settings_updated_flash'));

        return redirect()->route('account');
    }
}
