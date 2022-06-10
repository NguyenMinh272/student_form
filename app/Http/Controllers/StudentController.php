<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\StudentSubject;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\StudentSubject\StudentSubjectRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $studentRepo;
    protected $facultyRepo;
    protected $subjectRepo;

    public function __construct(
        StudentRepositoryInterface $studentRepo,
        FacultyRepositoryInterface $facultyRepo,
        SubjectRepositoryInterface $subjectRepo,
        StudentSubjectRepositoryInterface $resultRepo,
    ) {
        $this->studentRepo = $studentRepo;
        $this->facultyRepo = $facultyRepo;
        $this->subjectRepo = $subjectRepo;
        $this->resultRepo = $resultRepo;
    }

    public function index(Request $request)
    {
        $faculties = $this->facultyRepo->getFaculty()->pluck('name', 'id');
        $students = $this->studentRepo->search($request->all());
        return view('student.index', compact('students','faculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faculties = $this->facultyRepo->getFaculty()->pluck('name', 'id');

        return view('student.form', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        $data = $request->all();
//        $data['password'] = Str::random(10);
        $get_image = $request->file('image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalName();
            $get_image->move('images', $new_image);
            $data['image'] = $new_image;
        }
        $this->studentRepo->create($data);

        return redirect()->route('students.index')->with('success', 'Create student successful!');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = $this->studentRepo->find($id);

        return view('student.detail', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = $this->studentRepo->find($id);
        $faculties = $this->facultyRepo->getFaculty()->pluck('name', 'id');

        return view('student.form', compact('student', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function update(StudentRequest $request, $id)
    {
        $data = $request->all();
        $student = $this->studentRepo->find($id);
        $get_image = $request->file('image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalName();
            $get_image->move('images', $new_image);
            $data['image'] = $new_image;
        }
        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Create student successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->studentRepo->find($id);
        $data->delete();

        return redirect()->route('students.index')->with('success', 'Deleted successfully!');

    }

    public function createSubjects($id)
    {
        $subjects = $this->subjectRepo->getSubject();
        $student = $this->studentRepo->find($id);

        return view('student.register_subject', compact('student', 'subjects'));
    }

    public function storeSubject(Request $request, $id)
    {
        $this->studentRepo->find($id)->subjects()->syncWithoutDetaching($request['subject_id']);

        return redirect()->route('students.index')->with('success', 'Successfully !');
    }

    public function createMark($id)
    {
        $student = $this->studentRepo->find($id);

        return view('student.add_mark', compact('student'));
    }

    public function storeMark(Request $request)
    {
        $data = [];

        foreach ($request->subject_id as $key => $value) {
            array_push($data, [
                'subject_id' => $request->subject_id[$key],
                'mark' => $request->mark[$key],
            ]);
        }

        $marks = [];
        foreach ($data as $key => $value) {
            $marks[$value['subject_id']] = ['mark' => $value['mark']];
        }
        $this->studentRepo->find($request->student_id)->subjects()->sync($marks);

        return redirect()->route('students.index')->with('success', 'Successfully !');

    }

    public function updateApi(StudentRequest $request, $id) {
        try {
            $inputs = $request->all();
            $student = Student::findOrFail($id);

            if ($request->hasFile('image')) {
                $originName = $request->file('image')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;
                $request->file('image')->move(public_path(Student::$upload_dir), $fileName);
                $inputs['image'] = $fileName;
            } else {
                $inputs['image'] = $student->image;
            }
            $student->update($inputs);
            $data = [
                'data' => $student,
                'message' => "Cập nhật thành công"
            ];
            return Response::json($data);
        }catch (\Exception $e) {
            return Response::json(['message' => $e->getMessage()], $e->getCode());
        }
    }


}
