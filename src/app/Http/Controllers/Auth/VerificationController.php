<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;


class VerificationController extends Controller
{
    use VerifiesEmails;

    private const ROLE = [
        3 => 'customer', 
        2 => 'event.organisers',
        1 => 'applicant',
    ];

    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */
    
    protected string $redirectTo = '/registered';
    
    protected User $user;

    public function redirectTo()
    {
        $user = Auth::user();
        $roles = array_flip(self::ROLE);

        if ($user->role->role_id === $roles['customer']) {
            return $user->customer->first_name != null ? '/customers/' . $user->customer->id : $this->redirectTo;
        }

        if ($user->role->role_id === $roles['event.organiser']) {
            return $user->eventOrganiser->name != null ? '/event_organisers/' . $user->eventOrganiser->id : $this->redirectTo;
        }

    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
