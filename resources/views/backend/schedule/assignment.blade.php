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
                    <h1 class="page-title"> Phân bổ giảng dạy </h1>

                </header><!-- /.page-title-bar -->
                <!-- .page-section -->
                <div class="page-section">
                    <div class="section-block">
                        <!-- metric row -->
                        <div class="metric-row" style="overflow:auto">
                            <table class="tablePoint" cellspacing="0">
                                <tr>
                                    <th>Lớp</th>
                                    @foreach($subjects as $subject)
                                        <th>
                                            {{$subject->name}}
                                        </th>
                                    @endforeach
                                </tr>
                                <tbody>
                                @php($index = 0)
                                @foreach($classes as $class)
                                    @php($index++)
                                    <tr>
                                        <td>{{$class->name}}</td>
                                        @foreach($subjects as $subject)
                                            <td>
{{--                                                <input type="number" subject-id="{{$subject->id}}" class="point" class-id="{{$class->id}}">--}}
                                                <select
                                                    style="border: none; width: 100%;outline: none"
                                                    subject-id="{{$subject->id}}" class="teacher_option" class-id="{{$class->id}}">
                                                    <option value=""></option>
                                                @foreach($teachers as $teacher)
                                                    <option value="{{$teacher->id}}"
                                                            @if($assignments[$subject->id][$class->id] === $teacher->id )
                                                                selected
                                                                @endif
                                                    >{{$teacher->name}}</option>
                                                    @endforeach
                                                </select>
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

