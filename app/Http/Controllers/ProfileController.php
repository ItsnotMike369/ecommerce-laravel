<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the customer My Account page.
     */
    public function account(Request $request): View
    {
        $tab = in_array($request->get('tab'), ['profile','orders','wishlist','addresses','payment','settings'])
            ? $request->get('tab')
            : 'profile';

        $orders = collect();
        if (class_exists('\App\Models\Order')) {
            $orders = \App\Models\Order::where('user_id', $request->user()->id)
                ->orderByDesc('created_at')
                ->get();
        }

        $paymentMethods = $request->user()->paymentMethods()->orderByDesc('is_default')->orderBy('created_at')->get();

        return view('account', [
            'user'           => $request->user(),
            'tab'            => $tab,
            'orders'         => $orders,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Display the user's profile form (redirects to new account page).
     */
    public function edit(Request $request)
    {
        return redirect()->route('account', ['tab' => 'profile']);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('account', ['tab' => 'profile'])->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Save the user's shipping address.
     */
    public function saveAddress(Request $request): RedirectResponse
    {
        return Redirect::route('account', ['tab' => 'addresses'])->with('status', 'address-saved');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
