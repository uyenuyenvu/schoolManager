<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Company;
use App\Models\Division;
use App\Models\Exam;
use App\Models\Point;
use App\Models\Schedules;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function assignmentIndex()
    {
        $subjects = Subject::all();
        $teachers = Teacher::where('is_active',1)->get();
        $classes = Team::all();
        $newArr = [];
        foreach ($subjects as $subject){
            $newArr[$subject->id] = [];
            foreach ($classes as $class) {
                $ass = Assignment::where('subject_id',$subject->id)->where('class_id',$class->id)->first();
                $newArr[$subject->id][$class->id] = isset($ass->teacher_id) ? $ass->teacher_id : '';
            }
            }
        return view('backend.schedule.assignment')->with([
            'subjects'=>$subjects,
            'teachers'=>$teachers,
            'classes'=>$classes,
            'assignments'=>$newArr
        ]);
    }

    public function scheduleClass()
    {
        $subjects = Subject::all();
        $assignment_complete = true;
        $countClass = count(Team::all());
        $classes = Team::all();

        foreach ($subjects as $subject){
            $ass = count(Assignment::where('subject_id',$subject->id)->whereNotNull('teacher_id')->get());
            if ($ass < $countClass){
                $assignment_complete = false;
            }
            }
        return view('backend.schedule.class')->with([
            'classes'=>$classes,
            'assignment_complete'=>$assignment_complete
        ]);
    }
    public function scheduleByTeacher(Request $request)
    {
        $idUser = empty($request->input('id'))?auth()->id():$request->input('id');
        $classes = Team::all();
        $teachers = Teacher::where('is_active',1)->get();

        $schedules = collect(Schedules::where('teacher_id', $idUser)->with(['team','subject'])->get());
        $schedule = [];
        for ($indexDay = 0; $indexDay < 7; $indexDay++){
            $schedule[$indexDay]=[];
            for ($indexLesson=0; $indexLesson < 10; $indexLesson++){
                $schedule[$indexDay][$indexLesson] = $schedules
                    ->where('day_index', $indexDay)
                    ->where('lesson_index', $indexLesson)
                    ->first();
            }
        }
        $user = Teacher::find($idUser);
        if (!$user){
            $user = \auth()->user();
        }
        return view('backend.schedule.teacher')->with([
            'classes'=>$classes,
            'teachers'=>$teachers,
            'schedules'=>$schedule,
            'user'=>$user
        ]);
    }
    public function scheduleByClass($id)
    {
        $class = Team::find($id);
        $subjects = Subject::all();
        $schedules = collect(Schedules::where('class_id', $id)->with(['teacher','subject'])->get());
        $schedule = [];
        for ($indexDay = 0; $indexDay < 7; $indexDay++){
            $schedule[$indexDay]=[];
            for ($indexLesson=0; $indexLesson < 10; $indexLesson++){
                $schedule[$indexDay][$indexLesson] = $schedules
                                                    ->where('day_index', $indexDay)
                                                    ->where('lesson_index', $indexLesson)
                                                    ->first();
            }
        }
        return view('backend.schedule.scheduleClass')->with([
            'class'=>$class,
            'subjects'=>$subjects,
            'schedules'=>$schedule
        ]);
    }

    public function assignmentUpdate(Request $request)
    {
        $data = $request->all();
        try{
            $assignment = Assignment::where('class_id',$data['classId'])
                                    ->where('subject_id',$data['subjectId'])
                                    ->first();
            if ($assignment){
                $assignment->teacher_id = $data['teacherId'];
                $assignment->save();
            }else{
                $assignment = Assignment::create([
                   'class_id'=>$data['classId'],
                   'subject_id'=>$data['subjectId'],
                   'teacher_id'=>$data['teacherId'],
                ]);
            }

            if ($assignment){
                $message = 'Cập nhật thành công';
                return response()->json([
                    'error'     =>false,
                    'message'   =>$message,
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
    public function scheduleUpdate(Request $request)
    {
        $data = $request->all();
        try{
            $assignment = Assignment::where('class_id',$data['classId'])
                                    ->where('subject_id',$data['subjectId'])
                                    ->whereNotNull('teacher_id')
                                    ->first();
            if ($assignment){
                $schedule = Schedules::where('class_id',$data['classId'])
                                    ->where('day_index',$data['indexDay'])
                                    ->where('lesson_index',$data['indexLesson'])->first();
                if ($schedule){
                    $schedule->subject_id = $data['subjectId'];
                    $schedule->teacher_id = $assignment->teacher_id;
                    $schedule->save();
                }else{
                    $schedule = Schedules::create([
                        'class_id'=>$data['classId'],
                        'day_index'=>$data['indexDay'],
                        'lesson_index'=>$data['indexLesson'],
                        'subject_id'=>$data['subjectId'],
                        'teacher_id'=>$assignment->teacher_id,
                    ]);
                }
            }else{
                return response()->json([
                    'error'      =>true,
                    'message'    =>"chưa có giáo viên phụ trách môn học"
                ]);
            }

            if ($schedule){
                $message = 'success';
                return response()->json([
                    'error'     =>false,
                    'message'   =>$message,
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

    public function getData()
    {
        $exam = Exam::all();
        return $this->createDataTable($exam);
    }

    public function createDataTable($exam)
    {
        return DataTables::of($exam)
            ->editColumn('name',function($exam){
                return '<a href="'.route('admin.list-class',['id'=>$exam->id]).'">'.$exam->name.'</a>';
            })
            ->addColumn('action', function ($exam) {
                $string = '';
                $string .= '<a data-id="' . $exam->id . '"  class="btn btn-sm btn-icon btn-secondary btn-edit"  title="chỉnh sửa"><i class="fa fa-pencil-alt"></i></a>';
                $string .= '<a href="" data-id="' . $exam->id . '" class="btn btn-sm btn-icon btn-secondary btn-delete" title="xóa"> <i class="far fa-trash-alt"></i></a>';
                return $string;
            })
            ->addIndexColumn()
            ->rawColumns(['action','name'])
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

            $exam = Exam::findOrFail($id);

            $validate= Validator::make($request->all(),[
                'name'      => 'required|max:100',
                'year'      => 'required|max:100',
                'semester'      => 'required|max:100',
            ]);

            if(!$validate) return false;

            $exam = $exam->update($input);

            if ($exam){
                $message = 'Cập nhật thành công';
                return response()->json([
                    'error'     =>false,
                    'message'   =>$message
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
