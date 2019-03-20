<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApplicantContactDetails;
use App\Repositories\ApplicantContactDetailsRepository;
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

    protected function authenticated(Request $request, $user)
    {
        $list = $request->get('list');
        $event = $request->get('event');

        if ( Auth::check() ) {
            $contactDetails = ApplicantContactDetails::where('applicant_id', $user->applicant->id)->first();

            if (empty($contactDetails->id)) {
                return redirect()->route('users_profile.create');
            }

            if (! empty($list) && ! empty($event)) {
                return redirect()->route("applicant_lists.show", [
                    'list' => $list,
                    'event' => $event
                ]);
            }

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
        return '/events';
    }
}
