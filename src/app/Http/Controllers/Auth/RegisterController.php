<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Facades\App\Repositories\UserRepository;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $redirectTo = '/email/verify';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     */
    public function showRegistrationForm(Request $request)
    {
        $type = $request->get('type')?: '';
        $list = $request->get('list')?: '';
        $event = $request->get('event')?: '';
        
        return view('auth.register', [
            'type' => $type, 'list' => $list, 'event' => $event,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function selectAccountType(Request $request)
    {
        $list = $request->get('list');
        $event = $request->get('event');

        return view('auth/select_account_type', ['list' => $list, 'event' => $event]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'type' => ['required', 'string', Rule::in(['customer', 'organiser'])],
            'list' => 'nullable|integer',
            'event' => 'nullable|integer',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = UserRepository::create($data);

        if(!$user) {
            /** @todo send a message to tell the user something went wrong */
            return view('auth.register', ['type' => $type, 'list' => $list, 'event' => $event]);
        }
 
        return $user;
    }
}
