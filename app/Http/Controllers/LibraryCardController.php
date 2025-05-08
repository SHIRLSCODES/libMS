<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryCardController extends Controller
{
    public function showSubscribeForm(){
        return view ('library-card.subscribe');
    }
    public function showRenewForm(){
        $card = Auth::user()->libraryCard;
        return view('library-card.renew', compact('card'));
    }
}
