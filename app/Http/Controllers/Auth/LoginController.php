<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect after login
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Login field
     */
    public function username()
    {
        return 'user_name';
    }

    /**
     * Failed login response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Controller constructor
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}