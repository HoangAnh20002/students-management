<?php
namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use App\Enums\Base;

class LoginController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if ($this->authRepository->authenticate($credentials)) {
            if(Auth::user()->role == Base::Admin){
                return redirect('adminMain');
            }
            return redirect('studentMain');
        }
        return redirect('login')->withInput()->withErrors([
            'email' => 'Invalid email or password.'
        ]);
    }
    public function logout(){
        Auth::logout();
        return redirect('login');
    }

}

