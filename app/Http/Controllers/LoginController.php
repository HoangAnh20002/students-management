<?php
namespace App\Http\Controllers;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $authRepositoryInterface;

    public function __construct(AuthRepositoryInterface $authRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');
        if ($this->authRepositoryInterface->authenticate($credentials)) {
            return redirect()->intended();
        }
        return redirect()->back()->withInput()->withErrors([
            'name' => 'Lỗi đăng nhập.',
        ]);
    }

}

