<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:100', 'regex:/^[A-Za-zÀ-ú\s]+$/'],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users,email,' . $user->id],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.regex' => 'O nome deve conter apenas letras.',
            'name.max' => 'O nome não pode ter mais de 100 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido com domínio real.',
            'email.unique' => 'Este e-mail já está em uso por outro usuário.',
        ]);

        if ($request->email !== $user->email) {
            $user->email_verified_at = null;
        }

        $user->fill($request->only(['name', 'email']));
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'A senha informada está incorreta.',
            ]);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
