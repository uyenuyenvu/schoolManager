<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Exam;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexUser(Request $request)
    {
        $division = Division::get();
        $exams = Exam::get();
        $teachers = Teacher::get();

        return view('backend.dashboard')->with([
            'divisions'=>$division,
            'exams'=>$exams,
            'teachers'=>$teachers,
        ]);
    }

    public function indexTeacher(Request $request)
    {
        $division = Division::get();
        $exams = Exam::get();
        $teachers = Teacher::get();

        return view('backend.dashboard')->with([
            'divisions'=>$division,
            'exams'=>$exams,
            'teachers'=>$teachers,
        ]);
    }
}
