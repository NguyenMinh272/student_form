<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Models\Subject;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Student::class;
    }

    public function search($request)
    {
        $student = $this->model->query();
        $total = Subject::count('id');

        if (!empty($request['age_from'])) {
            $student->where('birthday', '<=', Carbon::now()->subYear($request['age_from']))->get();
        }

        if (!empty($request['age_to'])) {
            $student->where('birthday', '>=', Carbon::now()->subYear($request['age_to']));
        }

        if (!empty($request['mark_from'])) {
            $mark_from = $request['mark_from'];
            $student->whereHas('subjects', function ($q) use ($mark_from) {
                $q->where('mark', '>', 0);
                $q->where('mark', '>=', $mark_from);
            });
        }

        if (!empty($request['mark_to'])) {
            $mark_to = $request['mark_to'];
            $student->whereHas('subjects', function ($q) use ($mark_to) {
                $q->where('mark', '>', 0);
                $q->where('mark', '<=', $mark_to);
            });

        }

        if (!empty($request['option'])) {
            $total = Subject::count('id'); //4
            $operator = '>=';

            if ($request['option'] == "2") {
                $operator = '<';
            }

            $student->whereHas('subjects', function ($q) {
                $q->where('mark', '>', 0);
            }, $operator, $total);
        }

        return $student->paginate(5);
    }

    public function getStudent()
    {
        $student = Student::select('email', 'full_name')->withAvg('studentSubject', 'mark')
            ->groupBy("id")
            ->having('student_subjects_avg_mark', '<', 5);
        return $student->paginate(5);
    }
}
