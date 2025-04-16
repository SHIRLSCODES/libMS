<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use Illuminate\Http\Request;
use App\Models\User;
use App\Events\UserWasCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller

{
    public function index()
    {
       
        $users = User::paginate(3);
        
        return view('admin.index', compact('users'));
    }


    public function create(): View
    {
        return view('admin.create');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $plainPassword = $request->input('password');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'is_admin' => $request->has('is_admin'),
        ]);

        UserWasCreated::dispatch($user, $plainPassword);

        return redirect()->route('admin.index')->with('sucess', 'User created successfully.');
    }

    public function deactivate($id)
        {
            $user = User::findOrFail($id);
            $user->is_active = false;
            $user->save();

            return redirect()->back()->with('success', 'User deactivated successfully.');
        }
        public function activate($id)
        {
            $user = User::findOrFail($id);
            $user->is_active = true;
            $user->save();

            return redirect()->back()->with('success', 'User activated successfully.');
        }

        public function search(Request $request)
            {
                $query = $request->input('query');

                $users = User::where('name', 'like', "%$query%")
                            ->orWhere('email', 'like', "%$query%")
                            ->paginate(3);

                return view('admin.partials.user-list', compact('users'))->render();
            }
     
        public function borrowedBooks()
                {
                    $borrows = Borrow::with(['book', 'user'])->paginate(5);

                    return view('admin.borrowed-books.index', compact('borrows'));
                }

}
