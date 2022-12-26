<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::select('id','name','is_active')->where('is_active',1)->get();
        return view('backend.teacher.index')->with([
            'companies'=>$companies
        ]);
    }

    public function getData()
    {
        $teachers = Teacher::all();
        return $this->createDataTable($teachers);
    }

    public function createDataTable($teachers)
    {
        return DataTables::of($teachers)
            ->editColumn('phone',function($teacher){
                if($teacher->phone) return $teacher->phone;
                else return 'Đang cập nhật';
            })

            ->editColumn('is_active', function ($teacher)  {
                $string ='';
                if($teacher->is_active == 1)
                    $string .='<label class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox" class="switcher-input" checked="" data-id="'.$teacher->id.'"> <span class="switcher-indicator"></span> <span class="switcher-label-on"><i class="fas fa-check"></i></span> <span class="switcher-label-off"><i class="fas fa-times"></i></span></label>';
                else
                    $string .='<label class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox" class="switcher-input" data-id="'.$teacher->id.'"> <span class="switcher-indicator"></span> <span class="switcher-label-on"><i class="fas fa-check"></i></span> <span class="switcher-label-off"><i class="fas fa-times"></i></span></label>';

                return $string;
            })
            ->addColumn('action', function ($teacher) {
                $string = '';
                $string .= '<a data-id="' . $teacher->id . '"  class="btn btn-sm btn-icon btn-secondary btn-edit"  title="chỉnh sửa"><i class="fa fa-pencil-alt"></i></a>';
                $string .= '<a href="" data-id="' . $teacher->id . '" class="btn btn-sm btn-icon btn-secondary btn-delete" title="xóa"> <i class="far fa-trash-alt"></i></a>';
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
                'email'     => 'required|email|max:100',
                'title'     => 'required|max:100',
                'company_id'=>'required'
            ]);

            if(!$validate) return false;

            $input['password'] = Hash::make(env('ADMIN_PASSWORD',12345678));

            $teacher = Teacher::create($input);

            if ($teacher){
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
                'message'    =>$message
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
        $teacher = Teacher::findOrFail($id);

        return response()->json([
            'error' =>false,
            'teacher'  =>$teacher
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

            $teacher = Teacher::findOrFail($id);

            $validate= Validator::make($request->all(),[
                'name'      => 'required|max:100',
                'email'     => 'required|email|max:100',
                'title'     => 'required|max:100',
                'company_id'=> 'required'
            ]);

            if(!$validate) return false;


            $teacher = $teacher->update($input);

            if ($teacher){
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
        $teacher = Teacher::findOrFail($id);
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
