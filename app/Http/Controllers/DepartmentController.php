<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $departmentRepository;
    public function __construct(DepartmentRepository $departmentRepository){
        $this->departmentRepository = $departmentRepository;
    }
    public function index()
    {
        $departments = $this->departmentRepository->all();
        return view('department.index',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department.create');
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
        return view('department.edit',compact('department'));
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
            return redirect()->back()->with('error', 'Department not found');
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
            return redirect()->back()->with('error', 'Department not found');
        }

        $this->departmentRepository->delete($id);

        return redirect()->route('department.index')->with('success', 'Department deleted successfully');
    }
}
