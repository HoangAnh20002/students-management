<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository,){
        $this->departmentRepository = $departmentRepository;
    }
    public function index()
    {
        $page = 10;
        $role = Auth::user()->role;
        $departments = $this->departmentRepository->paginate($page);
        return view('department.index',compact('departments','role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Auth::user()->role;
        if ($role == '0') {
            return redirect('login')->with('error', 'Permission denied. Please log in with a valid account.');
        }
        return view('department.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $departmentData = [
            'name' => $request->input('name'),
        ];

        $this->departmentRepository->create($departmentData);

        return redirect('department')->with('success', 'Department added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $role = Auth::user()->role;
        if ($role == '0') {
            return redirect('login')->with('error', 'Permission denied. Please log in with a valid account.');
        }
        return view('department.edit',compact('department','role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $department = $this->departmentRepository->find($id);
        if (!$department) {
            return redirect('department')->with('error', 'Department not found');
        }

        $departmentData = [
            'name' => $request->input('name'),
        ];

        $this->departmentRepository->update($id, $departmentData);

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
