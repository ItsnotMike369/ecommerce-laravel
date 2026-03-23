<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function store(Request $request)
    {
        $type = $request->input('type', 'card');

        $rules = ['type' => 'required|in:card,ewallet,bank'];

        if ($type === 'card') {
            $rules += [
                'card_number' => 'required|string|min:13|max:19',
                'card_name'   => 'required|string|max:100',
                'card_expiry' => 'required|string|max:7',
                'card_type'   => 'nullable|string|max:20',
            ];
        } elseif ($type === 'ewallet') {
            $rules += [
                'ew_provider' => 'required|string|max:20',
                'ew_phone'    => 'required|string|max:20',
                'ew_name'     => 'required|string|max:100',
            ];
        } elseif ($type === 'bank') {
            $rules += [
                'bank_name'    => 'required|string|max:100',
                'bank_account' => 'required|string|max:30',
                'bank_holder'  => 'required|string|max:100',
                'bank_type'    => 'nullable|string|max:20',
            ];
        }

        $data = $request->validate($rules);
        $user = Auth::user();

        if ($type === 'card') {
            $raw       = preg_replace('/\D/', '', $data['card_number']);
            $lastFour  = substr($raw, -4);
            $cardBrand = $data['card_type'] ?? $this->detectCardBrand($raw);

            $iconClass = match (strtolower($cardBrand)) {
                'visa'       => 'visa',
                'mastercard' => 'mc',
                'amex'       => 'amex',
                default      => 'card',
            };
            $iconText = match (strtolower($cardBrand)) {
                'visa'       => 'VISA',
                'mastercard' => 'MC',
                'amex'       => 'AMEX',
                default      => 'CARD',
            };

            $pm = PaymentMethod::create([
                'user_id'    => $user->id,
                'type'       => 'card',
                'label'      => ucfirst($cardBrand) . ' •••• ' . $lastFour,
                'sub_label'  => 'Expires ' . $data['card_expiry'],
                'icon_class' => $iconClass,
                'icon_text'  => $iconText,
                'last_four'  => $lastFour,
                'expiry'     => $data['card_expiry'],
                'is_default' => $user->paymentMethods()->count() === 0,
                'meta'       => ['card_name' => $data['card_name'], 'brand' => $cardBrand],
            ]);
        } elseif ($type === 'ewallet') {
            $provider  = strtolower($data['ew_provider']);
            $iconClass = match ($provider) {
                'gcash'    => 'gcash',
                'paymaya'  => 'paymaya',
                'grabpay'  => 'grabpay',
                'shopeepay'=> 'shopeepay',
                default    => 'ewallet',
            };
            $iconText = match ($provider) {
                'gcash'    => 'GC',
                'paymaya'  => 'PM',
                'grabpay'  => 'GP',
                'shopeepay'=> 'SP',
                default    => 'EW',
            };

            $pm = PaymentMethod::create([
                'user_id'    => $user->id,
                'type'       => 'ewallet',
                'label'      => ucfirst($provider),
                'sub_label'  => $data['ew_phone'],
                'icon_class' => $iconClass,
                'icon_text'  => $iconText,
                'is_default' => $user->paymentMethods()->count() === 0,
                'meta'       => ['account_name' => $data['ew_name'], 'provider' => $provider],
            ]);
        } else {
            $pm = PaymentMethod::create([
                'user_id'    => $user->id,
                'type'       => 'bank',
                'label'      => $data['bank_name'],
                'sub_label'  => '•••• ' . substr(preg_replace('/\D/', '', $data['bank_account']), -4),
                'icon_class' => 'bank',
                'icon_text'  => 'BNK',
                'is_default' => $user->paymentMethods()->count() === 0,
                'meta'       => [
                    'account_number' => $data['bank_account'],
                    'account_holder' => $data['bank_holder'],
                    'account_type'   => $data['bank_type'] ?? '',
                ],
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'payment_method' => $pm]);
        }

        return redirect()->route('account', ['tab' => 'payment'])->with('success', 'Payment method added.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        $wasDefault = $paymentMethod->is_default;
        $paymentMethod->delete();

        if ($wasDefault) {
            $next = Auth::user()->paymentMethods()->first();
            if ($next) {
                $next->update(['is_default' => true]);
            }
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('account', ['tab' => 'payment'])->with('success', 'Payment method removed.');
    }

    public function setDefault(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        Auth::user()->paymentMethods()->update(['is_default' => false]);
        $paymentMethod->update(['is_default' => true]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('account', ['tab' => 'payment'])->with('success', 'Default payment method updated.');
    }

    private function detectCardBrand(string $number): string
    {
        if (preg_match('/^4/', $number)) return 'visa';
        if (preg_match('/^5[1-5]/', $number)) return 'mastercard';
        if (preg_match('/^3[47]/', $number)) return 'amex';
        return 'card';
    }
}
