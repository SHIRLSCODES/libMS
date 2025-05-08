<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\Borrow;
use App\Models\LibraryCard;
use Illuminate\Support\Facades\Auth;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function redirectToGateway(Request $request)
    {
        $amount  = 2000 * 100;
        $email = Auth::user()->email;

        $request->merge([
            'amount' => $amount,
            'email'  => $email,
            'callback_url' => route('paystack.callback'),
            'metadata'  => json_encode(['user_id' => Auth::id()]),
        ]);    

        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        $status = $paymentDetails['data']['status'];
        $amount = $paymentDetails['data']['amount'] / 100;
        $reference = $paymentDetails['data']['reference'];
        $userId = $paymentDetails['data']['metadata']['user_id'];

        $user = User::find($userId);
        Auth::login($user);

        Payment::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => $status,
            'reference' => $reference,
        ]);

        if($status === 'success'){
            $now = now();
            $newExpiry = $now->copy()->addMonth();

        if ($user->libraryCard){
            $user->libraryCard->update([
                'issued_at' => $now,
                'expires_at' => $newExpiry,
            ]);
        }
        else{
            LibraryCard::create([
                'user_id' => $user->id,
                'issued_at' => $now,
                'expires_at' => $newExpiry,
            ]);
        }
        return redirect()->route('books.index')->with('success','Library Card subscription successful! It expires in a month!');
      }
      return redirect()->route('books.index')->with('error','Payment failed. Please try again.');
   } 

      public function payFine(Borrow $borrow)
        {
            if ($borrow->fine_amount <= 0 || $borrow->fine_paid) {
                return redirect()->back()->with('error', 'No fine to pay.');
            }
            

            $amount = $borrow->fine_amount * 100; 
            $user = Auth::user();

            $paymentData = [
                'amount' => $amount,
                'email' => $user->email,
                'orderID' => 'FINE-' . $borrow->id,
                'currency' => 'NGN',
                'callback_url' => route('pay.fine.callback', $borrow->id),
                'metadata' => [
                    'borrow_id' => $borrow->id,
                    'user_id' => $user->id,
                    'type' => 'fine',
                ],
            ];
            

            return Paystack::getAuthorizationUrl($paymentData)->redirectNow();
        }
      public function fineCallback(Borrow $borrow)
        {
            $paymentDetails = Paystack::getPaymentData();
        
            if ($paymentDetails['status'] && $paymentDetails['data']['status'] === 'success') {
                $borrow->update(['fine_paid' => true]);
                $borrow->update(['fine_amount' => 0.00]);
        
                return redirect()->route('borrows.index')->with('success', 'Fine paid successfully.');
            }
        
            return redirect()->route('borrows.index')->with('error', 'Payment failed or was cancelled.');
        }
        
}
