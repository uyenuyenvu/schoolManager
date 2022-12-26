<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Facuty;
use App\Models\Student;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::select('id','name')->get();
        
        if(Auth::guard('teacher')->check()){
            $teams = Team::where('teacher_id',Auth::guard('teacher')->user()->id)->get();
        }
        return view('backend.student.index')->with([
            'teams'=>$teams
        ]);
    }

    public function getData(Request $request)
    {
        $students = Student::all();
        if(Auth::guard('teacher')->check()){
            $teamId=[];
            $teams = Team::select('id')->where('teacher_id',Auth::guard('teacher')->user()->id)->get();
            foreach($teams as $team){
                $teamId[]=$team->id;
            }
            $students = Student::whereIn('class_id', $teamId)->get();
        }
        return $this->createDataTable($students);
    }

    public function createDataTable($students)
    {
        return DataTables::of($students)
        ->addColumn('class',function($student){
            $team = Team::findOrFail($student->class_id);
            return $team->name;
        })
        
        ->addColumn('code',function($student){
            return $student->code;
        })
        ->addColumn('name',function($student){
            return $student->name;
        })
        
        ->addColumn('father_name',function($student){
            return $student->father_name;
        })
        
        ->addColumn('phone',function($student){
            return $student->phone;
        })
        ->addColumn('mother_name',function($student){
            return $student->mother_name;
        })
        ->addColumn('parent_phone',function($student){
            return $student->parent_phone;
        })
            ->addColumn('action', function ($student) {
                $string = '';
                $string .= '<a data-id="' . $student->id . '"  class="btn btn-sm btn-icon btn-secondary btn-edit"  title="chỉnh sửa"><i class="fa fa-pencil-alt"></i></a>';
                $string .= '<a href="" data-id="' . $student->id . '" class="btn btn-sm btn-icon btn-secondary btn-delete" title="xóa"> <i class="far fa-trash-alt"></i></a>';
                return $string;
            })
            ->addIndexColumn()
            ->rawColumns(['action','class','code','name','father_name','phone','mother_name','parent_phone'])
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
                'name'              => 'required|max:100',
                'class_id'         => 'required|max:100',
            ]);

            $oldStudent = Student::where('code',$request->input('code'))->get();
            if(count($oldStudent)>0){
                $message = 'Mã học sinh đã tồn tại';
            return response()->json([
                'error'      =>true,
                'message'    =>$message
            ]);
            }else{
                if(!$validate) return false;

                $student = Student::create($input);
    
                if ($student){
                    $message = 'Tạo mới thành công';
                    return response()->json([
                        'error'     =>false,
                        'message'   =>$message
                    ]);
                }
            }

        }catch (\Exception $e) {
            $message = 'Thêm mới thất bại';
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

            $student = Student::findOrFail($id);
            if($student->is_active == 1) $output['is_active'] = 0;
            else $output['is_active'] = 1;

            $success = $student->update($output);

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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);

        return response()->json([
            'error' =>false,
            'student'  =>$student
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();
        try{
            $student = Student::findOrFail($id);
            $validate= Validator::make($request->all(),[
                'name'              => 'required|max:100',
                'code'      => 'required|max:100',
                'class_id'         => 'required|max:100',
            ]);

            if(!$validate) return false;
            $oldStudent = Student::where('code',$request->input('code'))->get();
            if(count($oldStudent)>0 && $oldStudent[0]['id'] !== $id){
                $message = 'Mã học sinh đã tồn tại';
            return response()->json([
                'error'      =>true,
                'message'    =>$message
            ]);
            }else{
                $student = $student->update($input);

                if ($student){
                    $message = 'Cập nhật thành công';
                    return response()->json([
                        'error'     =>false,
                        'message'   =>$message
                    ]);
                }
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $success = $student->delete();
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
