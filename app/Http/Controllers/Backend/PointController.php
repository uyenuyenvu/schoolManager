<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Division;
use App\Models\Exam;
use App\Models\Point;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listClass($id)
    {
        $classes = Team::all();
        if(Auth::guard('teacher')->check()){
            $classes = Team::where('teacher_id',Auth::guard('teacher')->user()->id)->get();
        }
        return view('backend.point.classes')->with([
            'classes'=>$classes,
            'exam_id'=>$id
        ]);
    }
    public function pointInClass($id_class, $id_exam)
    {
        $students = Student::where('class_id', $id_class)->get();
        $subjects = Subject::all();
        $exam = Exam::find($id_exam);
        $student_with_point = [];
        foreach ($students as $student){
            $studentTemp = $student;
            foreach ($subjects as $subject){
                $point = Point::where('exam_id', $id_exam)
                                ->where('student_id', $student->id)
                                ->where('subject_id', $subject->id)
                                ->first();
                if ($point){
                    $studentTemp[$subject->id]=$point;
                }else{
                    $newPoint = Point::create([
                        'exam_id'=>$id_exam,
                        'student_id'=>$student->id,
                        'subject_id'=>$subject->id,
                        'classes_id'=>$id_class,
                    ]);
                    $studentTemp[$subject->id]=$newPoint;
                }
            }
            $pointExist = Point::whereNotNull('number')
            ->where('student_id', $student->id)
            ->where('exam_id', $id_exam)->get();
            $count = 0;
            if(count($pointExist) > 0){
                foreach($pointExist as $itemP){
                    $count += (float)$itemP->number;
                }
                $count = (float)($count/count($pointExist));
            }
            $studentTemp['count'] = number_format((float)$count, 2, '.', '');
            $student_with_point[] = $studentTemp;
        }
    //    dd($student_with_point);
        return view('backend.point.index')->with([
            'students'=>$student_with_point,
            'subjects'=>$subjects,
            'exam'=>$exam
        ]);
    }

    public function index()
    {
        return view('backend.exam.index');
    }

    public function getData()
    {
        $exam = Exam::all();
        return $this->createDataTable($exam);
    }

    public function createDataTable($exam)
    {
        return DataTables::of($exam)
            ->addColumn('action', function ($exam) {
                $string = '';
                $string .= '<a data-id="' . $exam->id . '"  class="btn btn-sm btn-icon btn-secondary btn-edit"  title="chỉnh sửa"><i class="fa fa-pencil-alt"></i></a>';
                $string .= '<a href="" data-id="' . $exam->id . '" class="btn btn-sm btn-icon btn-secondary btn-delete" title="xóa"> <i class="far fa-trash-alt"></i></a>';
                return $string;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        try{

            $validate= Validator::make($request->all(),[
                'name'      => 'required|max:100',
                'year'      => 'required|max:100',
                'semester'      => 'required|max:100',
            ]);

            if(!$validate) return false;

            $team = Exam::create($input);

            if ($team){
                $message = 'Tạo mới thành công';
                return response()->json([
                    'error'     =>false,
                    'message'   =>$message
                ]);
            }

        }catch (\Exception $e) {
            $message = 'Tạo mới thất bại';
            return response()->json([
                'error'      =>true,
                'message'    =>$e->getMessage()
            ]);
        }
    }

    public function changeStatus($id)
    {
        $output = [];
        try {

            $teacher = Teacher::findOrFail($id);
            if($teacher->is_active == 1) $output['is_active'] = 0;
            else $output['is_active'] = 1;

            $success = $teacher->update($output);

            if($success){
                $message = 'Thay đổi trạng thái thành công';
                return response()->json([
                    'error'     =>false,
                    'message'   =>$message,
                ]);
            }

        } catch (\Exception $e) {
            $message = 'Thay đổi trạng thái thất bại';
            return response()->json([
                'error'     =>true,
                'message'   =>$message,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);

        return response()->json([
            'error' =>false,
            'exam'  =>$exam
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();
        try{

            $point = Point::findOrFail($id);

            if ($point){
                $point->number = $input['number'];
                $point->save();
            }
            $pointExist = Point::whereNotNull('number')
            ->where('student_id', $point->student_id)
            ->where('exam_id', $point->exam_id)->get();
            $count = 0;
            if(count($pointExist) > 0){
                foreach($pointExist as $itemP){
                    $count += (float)$itemP->number;
                }
                $count = (float)($count/count($pointExist));
            }

            if ($point){
                $message = 'Cập nhật thành công';
                return response()->json([
                    'error'     =>false,
                    'message'   =>$message,
                    'count'     =>number_format((float)$count, 2, '.', '')
                ]);
            }
        }catch (\Exception $e) {
            $message = 'Có 1 lỗi gì đó! chờ dev fix';
            return response()->json([
                'error'      =>true,
                'message'    =>$message
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $success = $exam->delete();
        if($success){
            $message = 'Xóa thành công!';
            return response()->json([
                'error'     => false,
                'message'   => $message
            ]);
        }else{
            $message = 'Xóa thất bại!';
            return response()->json([
                'error'     => true,
                'message'   => $message
            ]);
        }
    }
}
