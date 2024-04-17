<?php

namespace App\Http\Controllers;
use App\Enums\Base;
use App\Http\Requests\ResultRequest;
use App\Models\Result;
use App\Repositories\ResultRepository;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;
use League\Csv\Writer;


class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $studentRepository;
    protected $resultRepository;

    public function __construct(StudentRepository $studentRepository, ResultRepository $resultRepository){
        $this->studentRepository = $studentRepository;
        $this->resultRepository = $resultRepository;
    }
    public function index()
    {
        $role = Auth::user()->role;
        $results = $this->resultRepository->getResultWithRelationship(Base::PAGE);

        return view('result.index',compact('role','results'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $role = auth()->user()->role;
        $student_id = $request->input('student_id');
        $student = $this->studentRepository->find($student_id);
        $results = $student->result;
        $studentCourse = $student->course;
        $courseDepartment = $student->department->last()->course;
        $notRegisteredCourses = $courseDepartment->diff($studentCourse)->pluck('name');

        if (!$student) {
            return redirect()->route('student.index')->with('error','Student not found');
        }

        return view('result.detail', compact('student','results','notRegisteredCourses','role'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResultRequest $request)
    {
        $marks = $request->input('marks');
        $resultIds = $request->input('result_ids');

        if (count($marks) > 0 && !empty($resultIds)) {
            $result = $this->resultRepository->updateMarks($resultIds, $marks);

            if (!$result) {
                return response()->json(['success' => false, 'message' => 'Result not found.'], 404);
            }
            return response()->json(['success' => true, 'message' => 'Marks updated successfully.'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid input data.'], 400);
        }
    }
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv',
        ],[
            'csv_file.required' => 'The file is required',
            'csv_file.mimes' => 'The type of file must be csv'
        ]);

        $file = $request->file('csv_file');
        $reader = Reader::createFromPath($file->getPathname(), 'r');
        $reader->setHeaderOffset(0);
        $results = $reader->getRecords();

        foreach ($results as $record) {
            $data = [
                'student_id' => $record['student_id'],
                'course_id' => $record['course_id'],
                'mark' => $record['mark'],
            ];
            $this->resultRepository->updateOrInsert('results', $data);
        }

        return redirect()->route('student.index')->with('success','Import successfully');
    }


    public function export()
    {
        $results = $this->resultRepository->all();
        $csv = Writer::createFromString('');
        $csv->insertOne(['ID', 'Student ID', 'Course ID', 'Mark']);

        foreach ($results as $result) {
            $csv->insertOne([$result->id, $result->student_id, $result->course_id, $result->mark]);
        }

        $csv->output('results.csv');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        //
    }
}
