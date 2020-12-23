<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    protected $modelFields = [
        "fio",
        "group",
        "course"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $students = Student::paginate($request->per_page);
        return $students;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fio' => 'required',
            'group'  => 'required',
            'course'  => 'required'
        ]);

        Student::create([
            'fio' => $request->fio,
            'group' => $request->group,
            'course' => $request->course
        ]);

        return redirect()->route('students.show', ['student' => 1]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $student = Student::find($id);

        return view('students.show')
            ->with('student', $student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        if (!$request->only($this->modelFields)) {
            return response()->json(['message', 'errors' => $this->modelFields], 422);
        }

        $student = Student::find($id);
        $student->update([
            'fio' => $request->fio,
            'group' => $request->group,
            'course' => $request->course
        ]);

        return response()->json(['data' => $student]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
