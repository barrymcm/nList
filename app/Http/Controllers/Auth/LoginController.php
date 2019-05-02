<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/about';

    public function showLoginForm(Request $request)
    {
        $list = $request->get('list')?: '';
        $event = $request->get('event')?: '';

        return view('auth.login', ['list' => $list, 'event' => $event]);
    }

    /**
     * @todo:: Refactor
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function authenticated(Request $request, $user)
    {
        $list = $request->get('list');
        $event = $request->get('event');

        if ( Auth::check() ) {

            if ($user->role->role_id) {
                $role = Role::find($user->role->role_id)->name;
                $request->session()->put('id', $user->id);

                return redirect()->route("{$role}s.create");
            }

            if (! empty($list) && ! empty($event)) {
                return redirect()->route("applicant_lists.show", [
                    'list' => $list,
                    'event' => $event
                ]);
            }

            $request->session()->put('userId', $user->id);

            return redirect('/home');
        }

        return redirect('/login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo(Request $request)
    {

    }
}
