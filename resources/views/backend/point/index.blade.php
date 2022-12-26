@extends('backend.layouts.master')

@section('scripts')
    <script src="{{asset('backend/custom/point.js')}}"></script>
@endsection
@section('contents')
    <div class="wrapper">
        <!-- .page -->
        <div class="page">
            <!-- .page-inner -->
            <div class="page-inner">
                <!-- .page-title-bar -->
                <header class="page-title-bar">
                    <!-- .breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">
                                <a href="#"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Tables</a>
                            </li>
                        </ol>
                    </nav><!-- /.breadcrumb -->
                    <!-- title -->
                    <h1 class="page-title"> Thêm điểm </h1>

                </header><!-- /.page-title-bar -->
                <!-- .page-section -->
                <div class="page-section">
                    <div class="section-block">
                        <!-- metric row -->
                        <div class="metric-row" style="overflow:auto">
                            <table class="tablePoint" cellspacing="0">
                                <tr>
                                    <th>STT</th>
                                    <th  style="min-width:70px">Mã HS</th>
                                    <th style="min-width:200px">Họ và tên</th>
                                    <th >DTB</th>
                                    @foreach($subjects as $subject)
                                    <th>
                                        {{$subject->name}}
                                    </th>
                                    @endforeach
                                </tr>
                                <tbody>
                                @php($index = 0)
                                @foreach($students as $student)
                                    @php($index++)
                                    <tr>
                                        <td>{{$index}}</td>
                                        <td>{{$student->code}}</td>
                                        <td>{{$student->name}}</td>
                                        <td id="std{{$student->id}}">{{$student->count}}</td>
                                        @foreach($subjects as $subject)
                                            <td>
                                                <input type="number" value="{{$student[$subject->id]->number}}" student-id="{{$student->id}}" class="point" data-id="{{$student[$subject->id]->id}}">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div><!-- /metric row -->
                    </div><!-- /.section-block -->

                </div><!-- /.page-section -->
            </div><!-- /.page-inner -->
        </div><!-- /.page -->
    </div>
@endsection

