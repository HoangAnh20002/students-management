<?php

namespace App\Http\Controllers;

use App\Enums\Base;
use App\Repositories\DepartmentRepository;
use App\Http\Requests\DepartmentRequest;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $departmentRepository;
    protected $studentRepository;

    public function __construct(DepartmentRepository $departmentRepository,StudentRepository $studentRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->studentRepository = $studentRepository;
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
            return redirect()->route('403');
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
            return redirect()->route('403');
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
        $department = $this->departmentRepository->find($id);
        if (!$department) {
            return redirect('department')->with('error', 'The record not found');
        }
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
    public function registerForm()
    {
        $user = auth()->user();
        $studentIDs = $user->student->pluck('id')->first();
        $student = $this->studentRepository->find($studentIDs);
        $departments = $this->departmentRepository->all();
        $registerDepartments = $student->department;
        return view('department.departmentRegister', compact('departments', 'student', 'registerDepartments'));
    }
    public function registerConfirm(Request $request)
    {
        $request->validate([
            'department' => 'required|integer|exists:departments,id',
        ],[
            'department.required' => 'At least one department must be selected',
            'department.integer' => 'The selected department is invalid',
            'department.exists' => 'The selected department is invalid',
        ]);
        $user = auth()->user();
        $studentIDs = $user->student->pluck('id')->first();
        $student = $this->studentRepository->find($studentIDs);
        $department = $request->input('department');
        $student->department()->attach($department);
        return redirect()->route('departments.register')->with('success', 'Department registered successfully.');
    }
}
