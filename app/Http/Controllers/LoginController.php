<?php
namespace App\Http\Controllers;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');
        if ($this->authRepository->authenticate($credentials)) {
            if(Auth::user()->role == 1){
                return redirect('adminMain');
            }
            return redirect('studentMain');
        }
        return redirect()->back()->withInput()->withErrors([
            'name' => 'Error input',
        ]);

    }
    public function logout(){
        Auth::logout();
        return redirect('login');
    }

}

