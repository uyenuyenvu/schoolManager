<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Company;
use App\Models\Division;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::all();
        $teachers = Teacher::where('is_active',1)->get();
        return view('backend.team.index')->with([
            'divisions'=>$divisions,
            'teachers'=>$teachers
        ]);
    }

    public function getData()
    {
        $teams = Team::all();
        return $this->createDataTable($teams);
    }

    public function createDataTable($teams)
    {
        return DataTables::of($teams)
            ->editColumn('students', function ($team)  {
                return count(Student::where('class_id', $team->id)->get());
            })
            ->editColumn('teacher', function ($team)  {
                $teacher = Teacher::find($team->teacher_id);
                if ($teacher){
                    return $teacher->name;
                }
                return "-";
            })
            ->addColumn('action', function ($team) {
                $string = '';
                $string .= '<a data-id="' . $team->id . '"  class="btn btn-sm btn-icon btn-secondary btn-edit"  title="chỉnh sửa"><i class="fa fa-pencil-alt"></i></a>';
                $string .= '<a href="" data-id="' . $team->id . '" class="btn btn-sm btn-icon btn-secondary btn-delete" title="xóa"> <i class="far fa-trash-alt"></i></a>';
                return $string;
            })
            ->addIndexColumn()
            ->rawColumns(['is_active', 'action'])
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
                'division_id'=>'required'
            ]);

            if(!$validate) return false;

            if (!$input['teacher_id']){
                $input['teacher_id'] = 0;
            }
            $input['is_active'] = 1;

            $team = Team::create($input);

            if ($team){
                $message = 'Tạo mới thành công';
                return response()->json([
                    'error'     =>false,
                    'message'   =>$message
                ]);
            }

        }catch (\Exception $e) {
            $message = 'Có 1 lỗi gì đó! chờ dev fix';
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
        $team = Team::findOrFail($id);

        return response()->json([
            'error' =>false,
            'team'  =>$team
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

            $team = Team::findOrFail($id);

            $validate= Validator::make($request->all(),[
                'name'      => 'required|max:100',
                'division_id'=> 'required'
            ]);

            if(!$validate) return false;

            if (!$input['teacher_id']){
                $input['teacher_id'] = 0;
            }
            $input['is_active'] = 1;

            $team = $team->update($input);

            if ($team){
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
        $teacher = Team::findOrFail($id);
        DB::table('assignment')->where('teacher_id', $id)->delete();
        $success = $teacher->delete();
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
