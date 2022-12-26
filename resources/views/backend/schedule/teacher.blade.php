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
                    <h1 class="page-title"> Thời khóa biểu giảng viên</h1>

                </header><!-- /.page-title-bar -->
                <!-- .page-section -->
                <div class="page-section">
                    <div class="section-block">
                        <!-- metric row -->
                        <div class="metric-row" style="overflow:auto">
                            <div class="form-group col-5">
                                <select name="company_id" id="company_id" class="form-control">
                                    <option value=""></option>
                                    @forelse($teachers as $teacher)
                                        <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <a class="btn btn-success" id="addCategory" style="margin-bottom: 2%">
                                <i class="fa fa-search"> </i> Tìm kiếm</a>
                        </div>
                        <div class="metric-row" style="overflow:auto">
                            <table class="tablePoint" cellspacing="0">
                                <tr style="text-align: center">
                                    <th>Tiết</th>
                                    <th>Thứ hai</th>
                                    <th>Thứ ba</th>
                                    <th>Thứ tư</th>
                                    <th>Thứ năm</th>
                                    <th>Thứ sáu</th>
                                    <th>Thứ 7</th>
                                    <th>Chủ nhật</th>
                                </tr>
                                <tbody>
                                @for ($indexLesson = 0; $indexLesson < 10; $indexLesson++)
                                    <tr>
                                        <td>{{$indexLesson + 1}}</td>
                                        @for ($indexDay = 0; $indexDay < 7; $indexDay++)
                                            <td>
                                                @if(rand(1, 10) === $indexLesson)

                                                Toán <b>10B1</b>
                                                @endif

                                            </td>
                                        @endfor
                                    </tr>
                                    @if($indexLesson === 4)
                                        <tr>
                                            <td colspan="8" style="border-left: none; border-right: none"></td>
                                        </tr>
                                    @endif
                                @endfor
                                </tbody>
                            </table>
                        </div><!-- /metric row -->
                    </div><!-- /.section-block -->

                </div><!-- /.page-section -->
            </div><!-- /.page-inner -->
        </div><!-- /.page -->
    </div>
@endsection

