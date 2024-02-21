<?php

namespace App\Http\Controllers;

use App\Enums\Base;
use App\Repositories\DepartmentRepository;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository,)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $role = Auth::user()->role;
        $departments = $this->departmentRepository->paginate(Base::PAGE);
        return view('department.index', compact('departments', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Auth::user()->role;
        if ($role == Base::STUDENT) {
            return redirect('login')->with('error', 'Permission denied. Please log in with a valid account.');
        }
        return view('department.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {

        $this->departmentRepository->create($request->only('name'));

        return redirect('department')->with('success', 'Department added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Auth::user()->role;
        if ($role == Base::STUDENT) {
            return redirect('login')->with('error', 'Permission denied. Please log in with a valid account.');
        }

        $department = $this->departmentRepository->find($id);

        if (!$department) {
            return redirect('department')->with('error', 'Department not found');
        }

        return view('department.edit', compact('department', 'role'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request)
    {
        $departmentData = $request->only('name');
        $id = $request->input('id');
        $this->departmentRepository->update($id,$departmentData);

        return redirect('department')->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $department = $this->departmentRepository->find($id);

        if (!$department) {
            return redirect('department')->with('error', 'Department not found');
        }

        $this->departmentRepository->delete($id);

        return redirect('department')->with('success', 'Department deleted successfully');
    }
}
