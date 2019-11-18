<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\Customer;
use App\Models\Organiser;
use Illuminate\Http\Request;
use App\Models\EventOrganiser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;

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
        Log::info('This is some info');

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

        if (Auth::check()) {
            if ($user->role->role_id) {
                $role = Role::find($user->role->role_id)->name;
                $request->session()->put('id', $user->id);

                if ($role == 'customer') {
                    $customer = Customer::find($user->customer->id);

                    return redirect()->route(
                        'customers.show',
                        ['customer' => $customer]
                    );
                }

                /**
                 * @todo : Organiser model is not currently used.
                 */
                if ($role == 'organiser') {
                    $organiser = EventOrganiser::find($user->organiser->id);

                    return redirect()->route(
                        'organisers.create',
                        ['organiser' => $organiser]
                    );
                }
            }

            if (! empty($list) && ! empty($event)) {
                return redirect()->route('applicant_lists.show', [
                    'list' => $list,
                    'event' => $event,
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
