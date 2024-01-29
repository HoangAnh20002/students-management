<?php

namespace App\Http\Middleware;

use App\Repositories\Interfaces\StudentRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**brod=
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


// ...
    protected $studentRepositoryInterface;

    public function __construct(StudentRepositoryInterface $studentRepositoryInterface)
    {
        $this->studentRepositoryInterface = $studentRepositoryInterface;
    }

    public function handle($request, Closure $next)
    {
        $userIds = $this->studentRepositoryInterface->all()->pluck('user_id')->toArray();
        if (Auth::check()) {
            $userId = Auth::id();
            if (!empty($userIds) && in_array($userId, $userIds)) {
                return redirect()->route('StudentMain');
            } else {
                return redirect()->route('AdminMain');
            }
        }
        return redirect()->route('login');
    }
}
